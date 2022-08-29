<?php

declare(strict_types=1);

namespace Feech\SmsAero\Dto;

use JMS\Serializer\Annotation as JMS;

class SmsMessageResult
{
    public const STATUS_QUEUED         = 0; // в очереди
    public const STATUS_DELIVERED      = 1; // доставлено
    public const STATUS_NOT_DELIVERED  = 2; // не доставлено
    public const STATUS_SENT           = 3; // передано
    public const STATUS_WAITING_STATUS = 4; // ожидание статуса сообщения
    public const STATUS_REJECTED       = 6; // сообщение отклонено
    public const STATUS_ON_MODERATION  = 8; // на модерации

    /**
     * @var int
     * @JMS\Type("int")
     */
    public $id;

    /**
     * @var string
     * @JMS\Type("string")
     */
    public $from;

    /**
     * @var string
     * @JMS\Type("string")
     */
    public $number;

    /**
     * @var string
     * @JMS\Type("string")
     */
    public $text;

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
     * @var string
     * @JMS\Type("string")
     */
    public $channel;

    /**
     * @var float
     * @JMS\Type("float")
     */
    public $cost;

    /**
     * @var int
     * @JMS\Type("int")
     * @JMS\SerializedName("dateCreate")
     */
    public $dateCreate;

    /**
     * @var int
     * @JMS\Type("int")
     * @JMS\SerializedName("dateSend")
     */
    public $dateSend;
}
