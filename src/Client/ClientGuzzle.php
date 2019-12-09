<?php

namespace Feech\SmsAero\Client;

use Feech\SmsAero\Auth\IAuth;

class ClientGuzzle implements IClient
{
    /**
     * @var string
     */
    private $url = 'https://gate.smsaero.ru/v2';

    /**
     * @var \GuzzleHttp\Client
     */
    private $client;

    /**
     * ClientGuzzle constructor.
     *
     * @param IAuth $auth
     */
    public function __construct(IAuth $auth)
    {
        $this->client = new \GuzzleHttp\Client([
            'auth' => [$auth->getEmail(), $auth->getPassword()]
        ]);
    }

    /**
     * @param string $path
     * @param array  $params
     *
     * @return string
     * @throws \Exception
     */
    private function request(string $path, array $params = []): string
    {
        $uri = $this->getUrl($path);
        if (!$uri) {
            throw new \Exception('Path is not correct');
        }

        $response = $this->client->post($uri, ['form_params' => $params]);

        if ($response->getStatusCode() === 200) {
            return (string)$response->getBody();
        } else {
            throw new \Exception(sprintf('Smsaero.ru problem. Status code is %s', $response->getStatusCode()), $response->getStatusCode());
        }
    }

    /**
     * @param string $path
     *
     * @return string
     */
    private function getUrl(string $path): string
    {
        return (is_string($path)) ? $this->url . $path : '';
    }

    /**
     * @param string $path
     * @param array  $params
     *
     * @return array
     * @throws \Exception
     */
    public function requestArray(string $path, array $params = []): array
    {
        return json_decode($this->request($path, $params), true);
    }

    /**
     * @param string $path
     * @param array  $params
     *
     * @return string
     * @throws \Exception
     */
    public function requestStr(string $path, array $params = []): string
    {
        return $this->request($path, $params);
    }
}