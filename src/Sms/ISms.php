<?php

declare(strict_types=1);

namespace Feech\SmsAero\Sms;

interface ISms
{
    /**
     * @return string|null
     */
    public function getNumber(): ?string;

    /**
     * @return array|null
     */
    public function getListNumbers(): ?array;

    /**
     * @return string
     */
    public function getText(): string;

    /**
     * @return string
     */
    public function getChannel(): string;
}