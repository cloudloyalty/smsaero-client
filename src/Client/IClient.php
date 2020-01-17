<?php

declare(strict_types=1);

namespace Feech\SmsAero\Client;

use Feech\SmsAero\Exception\BaseSmsAeroException;

interface IClient
{
    /**
     * @param string $path
     * @param array  $params
     *
     * @return string
     * @throws BaseSmsAeroException
     */
    public function request(string $path, array $params = []): string;
}