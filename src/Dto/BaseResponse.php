<?php

declare(strict_types=1);

namespace Feech\SmsAero\Dto;

use JMS\Serializer\Annotation as JMS;

class BaseResponse
{
    /**
     * @var boolean
     * @JMS\Type("boolean")
     */
    public $success;

    /**
     * @var string|null
     * @JMS\Type("string")
     */
    public $message;
}
