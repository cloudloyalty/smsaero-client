<?php

declare(strict_types=1);

namespace Feech\SmsAero\Exception;

use GuzzleHttp\Exception\GuzzleException;

class TransportException extends BaseSmsAeroException
{
    public static function fromGuzzleException(GuzzleException $e): self
    {
        return new self('SmsAero call failed: ' . $e->getMessage(), 0, $e);
    }
}
