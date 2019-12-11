<?php

namespace Feech\SmsAero\Client;


use Exception;
use Feech\SmsAero\Auth\IAuth;
use GuzzleHttp\Client;

class ClientGuzzle implements IClient
{
    /**
     * @var string
     */
    private const URL = 'https://gate.smsaero.ru/v2';

    /**
     * @var Client
     */
    private $client;

    /**
     * ClientGuzzle constructor.
     *
     * @param IAuth $auth
     */
    public function __construct(IAuth $auth)
    {
        $this->client = new Client([
            'auth' => [$auth->getEmail(), $auth->getPassword()]
        ]);
    }

    /**
     * @param string $path
     * @param array  $params
     *
     * @return string
     * @throws Exception
     */
    public function request(string $path, array $params = []): string
    {
        $url = $this->getUrl($path);
        if (!$url) {
            throw new Exception('Path is not correct');
        }

        $response = $this->client->post($url, ['form_params' => $params]);

        if ($response->getStatusCode() === 200) {
            return $response->getBody()->getContents();
        } else {
            throw new Exception(sprintf('Smsaero.ru problem. Status code is %s', $response->getStatusCode()), $response->getStatusCode());
        }
    }

    /**
     * @param string $path
     *
     * @return string
     */
    private function getUrl(string $path): string
    {
        return (is_string($path)) ? self::URL . $path : '';
    }
}