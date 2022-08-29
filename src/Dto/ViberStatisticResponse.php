<?php

declare(strict_types=1);

namespace Feech\SmsAero\Dto;

use JMS\Serializer\Annotation as JMS;

class ViberStatisticResponse extends BaseResponse
{
    /**
     * @var ViberNumberStatus[]
     * @JMS\Type("array<Feech\SmsAero\Dto\ViberNumberStatus>")
     */
    public $data;
}
