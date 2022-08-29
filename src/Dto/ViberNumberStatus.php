<?php

declare(strict_types=1);

namespace Feech\SmsAero\Dto;

use JMS\Serializer\Annotation as JMS;

class ViberNumberStatus
{
    public const STATUS_SENT          = 0; // отправлено
    public const STATUS_DELIVERED     = 1; // доставлено
    public const STATUS_READ          = 2; // прочитано
    public const STATUS_NOT_DELIVERED = 3; // не доставлено
    public const STATUS_ERROR         = 4; // ошибка

    /**
     * @var string
     * @JMS\Type("string")
     */
    public $number;

    /**
     * @var int
     * @JMS\Type("int")
     */
    public $status;

    /**
     * @var string
     * @JMS\Type("string")
     * @JMS\SerializedName("extendStatus")
     */
    public $extendStatus;

    /**
     * @var int
     * @JMS\Type("int")
     * @JMS\SerializedName("dateSend")
     */
    public $dateSend;
}
