<?php

declare(strict_types=1);

namespace Feech\SmsAeroTest\Client;

use Feech\SmsAero\Auth\Auth;
use Feech\SmsAero\Client\ClientGuzzle;
use Feech\SmsAero\Exception\TransportException;
use Feech\SmsAeroTest\StubData;
use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

final class ClientGuzzleTest extends TestCase
{
    /** @var MockHandler */
    private $mockHandler;

    /** @var HandlerStack */
    private $handlerStack;

    /** @var Client */
    private $guzzleClient;

    /** @var Auth */
    private $auth;

    protected function setUp(): void
    {
        parent::setUp();

        $this->mockHandler = new MockHandler();
        $this->handlerStack = HandlerStack::create($this->mockHandler);
        $this->guzzleClient = new Client([
            'connect_timeout' => 5,
            'timeout' => 5,
            'handler' => $this->handlerStack,
        ]);

        $this->auth = new Auth('user@test.mail', 'password');
    }

    public function testRequestWhenHappyPath(): void
    {
        $calledSend = false;
        $successResponse = StubData::sendToSingleNumberSuccessResponse();

        $this->mockHandler->append(function (Request $request, array $options) use (
            &$calledSend,
            $successResponse
        ) {
            $this->assertSame('POST', $request->getMethod());

            $this->assertSame(
                'https://gate.smsaero.ru/v2/sms/testsend',
                (string) $request->getUri()
            );

            $this->assertSame(
                ['Basic ' . base64_encode('user@test.mail:password')],
                $request->getHeader('Authorization')
            );
            $this->assertSame(
                ['application/x-www-form-urlencoded'],
                $request->getHeader('Content-type')
            );

            $body = (string) $request->getBody();
            $this->assertNotEmpty($body);
            $params = [];
            parse_str($body, $params);
            $this->assertEquals(
                [
                    'number' => '79990000000',
                    'text' => 'Test text',
                    'channel' => 'DIRECT',
                    'sign' => 'SMS Aero',
                ],
                $params
            );

            $calledSend = true;

            return new Response(200, [], $successResponse);
        });

        $client = new ClientGuzzle($this->auth, $this->guzzleClient);

        $result = $client->request('/sms/testsend', [
            'number' => '79990000000',
            'text' => 'Test text',
            'channel' => 'DIRECT',
            'sign' => 'SMS Aero',
            'dateSend' => null,
            'callbackUrl' => null
        ]);

        $this->assertTrue($calledSend);
        $this->assertSame($successResponse, $result);
    }

    public function testConstructorShouldNotSetAuthIntoGuzzleInstance(): void
    {
        $client = new ClientGuzzle($this->auth);

        $guzzleClientProperty = new \ReflectionProperty(ClientGuzzle::class, 'client');
        $guzzleClientProperty->setAccessible(true);

        $injectedClient = $guzzleClientProperty->getValue($client);
        $this->assertInstanceOf(ClientInterface::class, $injectedClient);
        $this->assertNull($injectedClient->getConfig('auth'));
    }

    public function testConstructorWhenInjectedClientShouldNotSetAuthIntoGuzzleInstance(): void
    {
        $client = new ClientGuzzle($this->auth, $this->guzzleClient);

        $guzzleClientProperty = new \ReflectionProperty(ClientGuzzle::class, 'client');
        $guzzleClientProperty->setAccessible(true);

        $injectedClient = $guzzleClientProperty->getValue($client);
        $this->assertInstanceOf(ClientInterface::class, $injectedClient);
        $this->assertNull($injectedClient->getConfig('auth'));
    }

    /**
     * @dataProvider dataGuzzleException
     */
    public function testWhenErrorShouldThrowExceptionNoMatterOfGuzzleOptions(
        array $guzzleOptions
    ): void {
        $this->mockHandler->append(
            new Response(401, [], StubData::authErrorResponse())
        );

        $guzzleClient = new Client(array_merge(
            $guzzleOptions,
            ['handler' => $this->handlerStack]
        ));
        $client = new ClientGuzzle($this->auth, $guzzleClient);

        $this->expectException(TransportException::class);
        $this->expectExceptionMessage('SmsAero call failed');

        $client->request('/auth');
    }

    public function dataGuzzleException(): array
    {
        return [
            'http_errors enabled (default)' => [
                'guzzleOptions' => [
                    'http_errors' => true,
                ],
            ],
            'http_errors disabled' => [
                'guzzleOptions' => [
                    'http_errors' => false,
                ],
            ],
        ];
    }
}
