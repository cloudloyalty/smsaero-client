<?php

declare(strict_types=1);

namespace Feech\SmsAero\Dto;

class ViberSendRequest
{
    public const CHANNEL_INFO = 'INFO';
    public const CHANNEL_OFFICIAL = 'OFFICIAL';
    public const CHANNEL_CASCADE = 'CASCADE';

    /**
     * @var string|null
     */
    private $number;

    /**
     * @var string[]|null
     */
    private $numbers;

    /**
     * @var int|string|null
     */
    private $groupId;

    /**
     * @var string
     */
    private $sign;

    /**
     * @var string
     */
    private $channel;

    /**
     * @var string
     */
    private $text;

    /**
     * @var string|null
     */
    private $imageSource;

    /**
     * @var string|null
     */
    private $textButton;

    /**
     * @var string|null
     */
    private $linkButton;

    /**
     * @var int|null
     */
    private $dateSend;

    /**
     * @var string|null
     */
    private $signSms;

    /**
     * @var string|null
     */
    private $textSms;

    /**
     * @var int|null
     */
    private $priceSms;

    /**
     * @var float|null
     */
    private $timeout;

    private function __construct()
    {
    }

    public static function toSingleNumber(
        string $number,
        string $sign,
        string $channel,
        string $text
    ): self {
        $request = new self();
        $request->number = $number;
        $request->sign = $sign;
        $request->channel = $channel;
        $request->text = $text;

        return $request;
    }

    /**
     * @param string[] $numbers
     * @param string $sign
     * @param string $channel
     * @param string $text
     */
    public static function toMultipleNumbers(
        array $numbers,
        string $sign,
        string $channel,
        string $text
    ): self {
        assert(count($numbers) > 0 && count($numbers) <= 50);

        $request = new self();
        $request->numbers = $numbers;
        $request->sign = $sign;
        $request->channel = $channel;
        $request->text = $text;

        return $request;
    }

    /**
     * @param int|string $groupId
     * @param string $sign
     * @param string $channel
     * @param string $text
     */
    public static function toGroup(
        $groupId,
        string $sign,
        string $channel,
        string $text
    ): self {
        assert(is_int($groupId) || $groupId === 'all');

        $request = new self();
        $request->groupId = $groupId;
        $request->sign = $sign;
        $request->channel = $channel;
        $request->text = $text;

        return $request;
    }

    public function toArray(): array
    {
        $data = [
            'number' => $this->number,
            'numbers' => $this->numbers,
            'groupId' => $this->groupId,
            'sign' => $this->sign,
            'channel' => $this->channel,
            'text' => $this->text,
            'imageSource' => $this->imageSource,
            'textButton' => $this->textButton,
            'linkButton' => $this->linkButton,
            'dateSend' => $this->dateSend,
            'signSms' => $this->signSms,
            'textSms' => $this->textSms,
            'priceSms' => $this->priceSms,
            'timeout' => $this->timeout,
        ];

        return array_filter(
            $data,
            function ($value) {
                return $value !== null;
            }
        );
    }

    public function setImageSource(?string $imageContent, ?string $type): self
    {
        if ($imageContent === null) {
            $this->imageSource = null;
        } else {
            assert(in_array($type, ['png', 'jpg', 'gif']));
            $this->imageSource = $type . '#' . base64_encode($imageContent);
        }

        return $this;
    }

    public function setTextButton(?string $textButton): self
    {
        $this->textButton = $textButton;

        return $this;
    }

    public function setLinkButton(?string $linkButton): self
    {
        $this->linkButton = $linkButton;

        return $this;
    }

    public function setDateSend(?\DateTimeInterface $dateSend): self
    {
        if ($dateSend === null) {
            $this->dateSend = null;
        } else {
            $this->dateSend = $dateSend->getTimestamp();
        }

        return $this;
    }

    public function setSignSms(?string $signSms): self
    {
        $this->signSms = $signSms;

        return $this;
    }

    public function setTextSms(?string $textSms): self
    {
        $this->textSms = $textSms;

        return $this;
    }

    public function setPriceSms(?int $priceSms): self
    {
        $this->priceSms = $priceSms;

        return $this;
    }

    public function setTimeout(?float $timeout): self
    {
        $this->timeout = $timeout;

        return $this;
    }
}
