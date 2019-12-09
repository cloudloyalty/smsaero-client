<?php

namespace Feech\SmsAero\Client;


interface IClient
{
    /**
     * @param string $path
     * @param array  $params
     *
     * @return array
     * @throws \Exception
     */
    public function requestArray(string $path, array $params = []): array;

    /**
     * @param string $path
     * @param array  $params
     *
     * @return string
     * @throws \Exception
     */
    public function requestStr(string $path, array $params = []): string;
}