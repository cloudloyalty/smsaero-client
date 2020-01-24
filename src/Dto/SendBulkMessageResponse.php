<?php

declare(strict_types=1);

namespace Feech\SmsAero\Dto;

use JMS\Serializer\Annotation as JMS;

class SendBulkMessageResponse extends BaseResponse
{
    /**
     * @var SmsMessageResult[]
     * @JMS\Type("array<Feech\SmsAero\Dto\SmsMessageResult>")
     */
    public $data;
}
