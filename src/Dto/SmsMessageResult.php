<?php

declare(strict_types=1);

namespace Feech\SmsAero\Dto;

use JMS\Serializer\Annotation as JMS;

class SmsMessageResult
{
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
