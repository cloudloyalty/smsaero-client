<?php

namespace Feech\SmsAero\Client;


use Exception;

interface IClient
{
    /**
     * @param string $path
     * @param array  $params
     *
     * @return string
     * @throws Exception
     */
    public function request(string $path, array $params = []): string;
}