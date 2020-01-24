<?php

declare(strict_types=1);

namespace Feech\SmsAero\Exception;

use JMS\Serializer\Exception\RuntimeException;

class BadResponseException extends BaseSmsAeroException
{
    public static function becauseOfDeserializationError(RuntimeException $e): self
    {
        return new self('Unknown response: ' . $e->getMessage(), 0, $e);
    }
}
