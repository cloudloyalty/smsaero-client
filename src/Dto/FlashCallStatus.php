<?php

declare(strict_types=1);

namespace Feech\SmsAero\Dto;

use JMS\Serializer\Annotation as JMS;

class FlashCallStatus
{
    public const STATUS_QUEUED      = 0; // в очереди
    public const STATUS_DIALLED     = 1; // дозвон
    public const STATUS_NOT_DIALLED = 2; // не дозвон
    public const STATUS_SENT        = 4; // передано оператору

    /**
     * @var int
     * @JMS\Type("int")
     */
    public $id;

    /**
     * @var int
     * @JMS\Type("int")
     */
    public $status;

    /**
     * @var string
     * @JMS\Type("string")
     */
    public $code;

    /**
     * @var string
     * @JMS\Type("string")
     */
    public $phone;

    /**
     * @var float
     * @JMS\Type("float")
     */
    public $cost;

    /**
     * @var int
     * @JMS\Type("int")
     * @JMS\SerializedName("timeCreate")
     */
    public $timeCreate;

    /**
     * @var int
     * @JMS\Type("int")
     * @JMS\SerializedName("timeUpdate")
     */
    public $timeUpdate;
}
