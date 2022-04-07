<?php

declare(strict_types=1);

namespace Feech\SmsAero\Dto;

use JMS\Serializer\Annotation as JMS;

class FlashCallResponse extends BaseResponse
{
    /**
     * @var FlashCallStatus|null
     * @JMS\Type("Feech\SmsAero\Dto\FlashCallStatus")
     */
    public $data;
}
