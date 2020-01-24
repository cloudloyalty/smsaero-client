<?php

declare(strict_types=1);

namespace Feech\SmsAeroTest;

use Feech\SmsAero\Auth\Auth;
use Feech\SmsAero\Client\ClientGuzzle;
use Feech\SmsAero\Dto;
use Feech\SmsAero\Exception\BadResponseException;
use Feech\SmsAero\Exception\TransportException;
use Feech\SmsAero\Sms\Sms;
use Feech\SmsAero\SmsAeroClient;
use Feech\SmsAeroTest\StubData;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use JMS\Serializer\SerializerBuilder;
use PHPUnit\Framework\TestCase;

final class SmsAeroClientTest extends TestCase
{
    /** @var MockHandler */
    private $mockHandler;

    /** @var SmsAeroClient */
    private $client;

    protected function setUp(): void
    {
        parent::setUp();

        $this->mockHandler = new MockHandler();
        $handlerStack = HandlerStack::create($this->mockHandler);

        $httpClient = new ClientGuzzle(
            new Auth('user@test.mail', 'password'),
            new Client(['handler' => $handlerStack])
        );

        $serializer = SerializerBuilder::create()->build();

        $this->client = new SmsAeroClient($httpClient, $serializer);
    }

    public function testAuthWhenSuccess(): void
    {
        $this->mockHandler->append(function (Request $request, array $options) {
            $this->assertStringContainsString(
                '/v2/auth',
                (string) $request->getUri()
            );

            return new Response(200, [], StubData::authSuccessResponse());
        });

        $result = $this->client->auth();

        $this->assertTrue($result->success);
        $this->assertSame('Successful authorization.', $result->message);
    }

    public function testAuthWhenErrorShouldThrowException(): void
    {
        $this->mockHandler->append(
            new Response(401, [], StubData::authErrorResponse())
        );

        $this->expectException(TransportException::class);

        $this->client->auth();
    }

    public function testAuthWhenUnknownResponseShouldThrowException(): void
    {
        $this->mockHandler->append(
            new Response(200, [], '')
        );

        $this->expectException(BadResponseException::class);

        $this->client->auth();
    }

    public function testTestSendWhenSuccess(): void
    {
        $this->mockHandler->append(function (Request $request, array $options) {
            $this->assertStringContainsString(
                '/v2/sms/testsend',
                (string) $request->getUri()
            );

            return new Response(200, [], StubData::sendToSingleNumberSuccessResponse());
        });

        $sms = Sms::toSingleNumber('79990000000', 'Test text', Sms::CHANNEL_TYPE_DIRECT);

        $result = $this->client->testSend($sms);

        $this->assertTrue($result->success);
        $this->assertNull($result->message);

        $this->assertInstanceOf(Dto\SmsMessageResult::class, $result->data);
        $this->assertSmsMessageResultToTestData($result->data);
    }

    private function assertSmsMessageResultToTestData(Dto\SmsMessageResult $result): void
    {
        $this->assertSame(5, $result->id);
        $this->assertSame('BIZNES', $result->from);
        $this->assertSame('79990000000', $result->number);
        $this->assertSame('Test text', $result->text);
        $this->assertSame(0, $result->status);
        $this->assertSame('queue', $result->extendStatus);
        $this->assertSame(Sms::CHANNEL_TYPE_DIRECT, $result->channel);
        $this->assertSame(2.2, $result->cost);
        $this->assertSame(1532342510, $result->dateCreate);
        $this->assertSame(1532342510, $result->dateSend);
    }

    public function testTestSendWhenUnknownResponseShouldThrowException(): void
    {
        $this->mockHandler->append(
            new Response(200, [], '')
        );

        $sms = Sms::toSingleNumber('79990000000', 'Test text', Sms::CHANNEL_TYPE_DIRECT);

        $this->expectException(BadResponseException::class);

        $this->client->testSend($sms);
    }

    public function testTestSendWhenRequestValidationError(): void
    {
        $this->mockHandler->append(
            new Response(400, [], StubData::sendToSingleNumberErrorResponse())
        );

        $sms = Sms::toSingleNumber('00000000000', 'Test text', Sms::CHANNEL_TYPE_DIRECT);

        $this->expectException(TransportException::class);

        $this->client->testSend($sms);
    }

    public function testTestSendWhenSendToMultipleNumbersShouldThrowException(): void
    {
        $sms = Sms::toMultipleNumbers(['79990000000'], 'Test text', Sms::CHANNEL_TYPE_DIRECT);

        $this->expectException(\InvalidArgumentException::class);

        $this->client->testSend($sms);
    }

    public function testSendWhenSuccess(): void
    {
        $this->mockHandler->append(function (Request $request, array $options) {
            $this->assertStringContainsString(
                '/v2/sms/send',
                (string) $request->getUri()
            );

            return new Response(200, [], StubData::sendToSingleNumberSuccessResponse());
        });

        $sms = Sms::toSingleNumber('79990000000', 'Test text', Sms::CHANNEL_TYPE_DIRECT);

        $result = $this->client->send($sms);

        $this->assertTrue($result->success);
        $this->assertNull($result->message);

        $this->assertInstanceOf(Dto\SmsMessageResult::class, $result->data);
        $this->assertSmsMessageResultToTestData($result->data);
    }

    public function testSendWhenUnknownResponseShouldThrowException(): void
    {
        $this->mockHandler->append(
            new Response(200, [], '')
        );

        $this->expectException(BadResponseException::class);

        $sms = Sms::toSingleNumber('79990000000', 'Test text', Sms::CHANNEL_TYPE_DIRECT);

        $this->client->send($sms);
    }

    public function testSendWhenSendToMultipleNumbersShouldThrowException(): void
    {
        $sms = Sms::toMultipleNumbers(['79990000000'], 'Test text', Sms::CHANNEL_TYPE_DIRECT);

        $this->expectException(\InvalidArgumentException::class);

        $this->client->send($sms);
    }

    public function testBulkSendWhenSuccess(): void
    {
        $this->mockHandler->append(function (Request $request, array $options) {
            $this->assertStringContainsString(
                '/v2/sms/send',
                (string) $request->getUri()
            );

            return new Response(200, [], StubData::sendToMultipleNumbersSuccessResponse());
        });

        $sms = Sms::toMultipleNumbers(['79990000000'], 'Test text', Sms::CHANNEL_TYPE_DIRECT);

        $result = $this->client->bulkSend($sms);

        $this->assertTrue($result->success);
        $this->assertNull($result->message);

        $this->assertIsArray($result->data);
        $this->assertCount(1, $result->data);
        $messageResult = reset($result->data);
        $this->assertInstanceOf(Dto\SmsMessageResult::class, $messageResult);
        $this->assertSmsMessageResultToTestData($messageResult);
    }

    public function testBulkSendWhenUnknownResponseShouldThrowException(): void
    {
        $this->mockHandler->append(
            new Response(200, [], '')
        );

        $this->expectException(BadResponseException::class);

        $sms = Sms::toMultipleNumbers(['79990000000'], 'Test text', Sms::CHANNEL_TYPE_DIRECT);

        $this->client->bulkSend($sms);
    }

    public function testBulkSendWhenSendToSingleNumberShouldThrowException(): void
    {
        $sms = Sms::toSingleNumber('79990000000', 'Test text', Sms::CHANNEL_TYPE_DIRECT);

        $this->expectException(\InvalidArgumentException::class);

        $this->client->bulkSend($sms);
    }
}
