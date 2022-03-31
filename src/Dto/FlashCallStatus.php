<?php

declare(strict_types=1);

namespace Feech\SmsAero\Dto;

use JMS\Serializer\Annotation as JMS;

class FlashCallStatus
{
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
