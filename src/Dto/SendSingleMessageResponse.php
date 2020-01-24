<?php

declare(strict_types=1);

namespace Feech\SmsAero\Dto;

use JMS\Serializer\Annotation as JMS;

class SendSingleMessageResponse extends BaseResponse
{
    /**
     * @var SmsMessageResult
     * @JMS\Type("Feech\SmsAero\Dto\SmsMessageResult")
     */
    public $data;
}
