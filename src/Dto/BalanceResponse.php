<?php

declare(strict_types=1);

namespace Feech\SmsAero\Dto;

use JMS\Serializer\Annotation as JMS;

class BalanceResponse extends BaseResponse
{
    /**
     * @var BalanceResult
     * @JMS\Type("Feech\SmsAero\Dto\BalanceResult")
     */
    public $data;
}
