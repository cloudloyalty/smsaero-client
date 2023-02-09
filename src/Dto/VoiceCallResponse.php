<?php

declare(strict_types=1);

namespace Feech\SmsAero\Dto;

use JMS\Serializer\Annotation as JMS;

class VoiceCallResponse extends BaseResponse
{
    /**
     * @var VoiceCallStatus|null
     * @JMS\Type("Feech\SmsAero\Dto\VoiceCallStatus")
     */
    public $data;
}
