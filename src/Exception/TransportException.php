<?php

declare(strict_types=1);

namespace Feech\SmsAero\Exception;

use GuzzleHttp\Exception\TransferException;

class TransportException extends BaseSmsAeroException
{
    public static function fromGuzzleException(TransferException $e): self
    {
        return new self('SmsAero call failed: ' . $e->getMessage(), 0, $e);
    }
}
