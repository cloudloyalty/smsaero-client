<?php

declare(strict_types=1);

namespace Feech\SmsAero\Dto;

use JMS\Serializer\Annotation as JMS;

class ViberStatus
{
    public const STATUS_REJECTED      = 0; // отклонена
    public const STATUS_ON_MODERATION = 1; // на модерации
    public const STATUS_PROCESSING    = 2; // в работе
    public const STATUS_COMPLETED     = 3; // выполнена
    public const STATUS_SCHEDULED     = 4; // запланирована
    public const STATUS_NO_FUNDS      = 5; // недостаточно средств

    /**
     * @var int
     * @JMS\Type("int")
     */
    public $id;

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

    /**
     * @var int
     * @JMS\Type("int")
     */
    public $count;

    /**
     * @var string
     * @JMS\Type("string")
     */
    public $sign;

    /**
     * @var string
     * @JMS\Type("string")
     */
    public $channel;

    /**
     * @var string
     * @JMS\Type("string")
     */
    public $text;

    /**
     * @var float
     * @JMS\Type("float")
     */
    public $cost;

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
     * @JMS\SerializedName("countSend")
     */
    public $countSend;

    /**
     * @var int
     * @JMS\Type("int")
     * @JMS\SerializedName("countDelivered")
     */
    public $countDelivered;

    /**
     * @var int
     * @JMS\Type("int")
     * @JMS\SerializedName("countWrite")
     */
    public $countWrite;

    /**
     * @var int
     * @JMS\Type("int")
     * @JMS\SerializedName("countUndelivered")
     */
    public $countUndelivered;

    /**
     * @var int
     * @JMS\Type("int")
     * @JMS\SerializedName("countError")
     */
    public $countError;
}
