<?php

namespace Feech\SmsAero\Sms;

class Sms implements ISms
{
    /**
     * @var string
     */
    private $number;
    /**
     * @var array
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

    const CHANNEL_TYPE_INFO = 'INFO';
    const CHANNEL_TYPE_DIRECT = 'DIRECT';
    const CHANNEL_TYPE_DIGITAL = 'DIGITAL';
    const CHANNEL_TYPE_SERVICE = 'SERVICE';
    const CHANNEL_TYPE_INTERNATIONAL = 'INTERNATIONAL';

    const CHANNEL_TYPE = [
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

    /**
     * @return string
     */
    public function getNumber(): string
    {
        return $this->number;
    }

    /**
     * @return array
     */
    public function getListNumbers(): array
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