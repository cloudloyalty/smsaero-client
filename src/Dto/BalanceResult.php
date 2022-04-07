<?php

declare(strict_types=1);

namespace Feech\SmsAero\Dto;

use JMS\Serializer\Annotation as JMS;

class BalanceResult
{
    /**
     * @var float
     * @JMS\Type("float")
     */
    public $balance;
}
