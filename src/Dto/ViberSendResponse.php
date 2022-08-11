<?php

declare(strict_types=1);

namespace Feech\SmsAero\Dto;

use JMS\Serializer\Annotation as JMS;

class ViberSendResponse extends BaseResponse
{
    /**
     * @var ViberStatus|null
     * @JMS\Type("Feech\SmsAero\Dto\ViberStatus")
     */
    public $data;
}
