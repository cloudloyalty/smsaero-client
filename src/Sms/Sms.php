<?php

declare(strict_types=1);

namespace Feech\SmsAero\Sms;

class Sms implements ISms
{
    /**
     * @var string|null
     */
    private $number;
    /**
     * @var array|null
     */
    private $listNumbers;
    /**
     * @var string
     */
    private $text;
    /**
     * @var string
     */
    private $channel;

    public const CHANNEL_TYPE_INFO = 'INFO';
    public const CHANNEL_TYPE_DIRECT = 'DIRECT';
    public const CHANNEL_TYPE_DIGITAL = 'DIGITAL';
    public const CHANNEL_TYPE_SERVICE = 'SERVICE';
    public const CHANNEL_TYPE_INTERNATIONAL = 'INTERNATIONAL';

    private const CHANNEL_TYPE = [
        'INFO'          => 'Инфоподпись для всех операторов',
        'DIGITAL'       => 'Цифровой канал отправки (допускается только транзакционный трафик)',
        'INTERNATIONAL' => 'Международная доставка (Операторы РФ, Казахстана, Украины и Белоруссии)',
        'DIRECT'        => 'Рекламный канал отправки сообщений с бесплатной буквенной подписью.',
        'SERVICE'       => 'Сервисный канал для отправки сервисных SMS по утвержденному шаблону с платной подписью отправителя.',
    ];

    /**
     * Sms constructor.
     *
     * @param string|array $number
     * @param string       $text
     * @param string       $channel
     */
    public function __construct($number, string $text, string $channel)
    {
        if (is_array($number)) {
            $this->listNumbers = $number;
        } else {
            $this->number = $number;
        }

        $this->text = $text;

        if (array_key_exists($channel, self::CHANNEL_TYPE)) {
            $this->channel = $channel;
        } else {
            $this->channel = 'INFO';
        }
    }

    public static function toSingleNumber(string $number, string $text, string $channel): self
    {
        return new self($number, $text, $channel);
    }

    public static function toMultipleNumbers(array $numbers, string $text, string $channel): self
    {
        return new self($numbers, $text, $channel);
    }

    /**
     * @return string|null
     */
    public function getNumber(): ?string
    {
        return $this->number;
    }

    /**
     * @return array|null
     */
    public function getListNumbers(): ?array
    {
        return $this->listNumbers;
    }

    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * @return string
     */
    public function getChannel(): string
    {
        return $this->channel;
    }
}