<?php

declare(strict_types=1);

namespace Feech\SmsAero\Client;

use Feech\SmsAero\Auth\IAuth;
use Feech\SmsAero\Exception\BaseSmsAeroException;
use Feech\SmsAero\Exception\TransportException;
use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\TransferException;

class ClientGuzzle implements IClient
{
    /**
     * @var string
     */
    private const URL = 'https://gate.smsaero.ru/v2';

    /**
     * @var IAuth
     */
    private $auth;

    /**
     * @var ClientInterface
     */
    private $client;

    public function __construct(IAuth $auth, ClientInterface $client = null)
    {
        $this->auth = $auth;

        if ($client === null) {
            $this->client = new Client();
        } else {
            $this->client = $client;
        }
    }

    /**
     * @param string $path
     * @param array  $params
     *
     * @return string
     * @throws BaseSmsAeroException
     */
    public function request(string $path, array $params = []): string
    {
        $url = $this->getUrl($path);

        try {
            $response = $this->client->request(
                'POST',
                $url,
                [
                    'form_params' => $params,
                    'auth' => [$this->auth->getEmail(), $this->auth->getPassword()],
                    'http_errors' => true,
                ]
            );
        } catch (TransferException $e) {
            throw TransportException::fromGuzzleException($e);
        }

        if ($response->getStatusCode() === 200) {
            return (string) $response->getBody();
        } else {
            throw new TransportException(
                sprintf('Smsaero.ru problem. Status code is %s', $response->getStatusCode()),
                $response->getStatusCode()
            );
        }
    }

    /**
     * @param string $path
     *
     * @return string
     */
    private function getUrl(string $path): string
    {
        return self::URL . $path;
    }
}