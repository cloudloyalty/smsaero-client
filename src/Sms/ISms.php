<?php

namespace Feech\SmsAero\Sms;


interface ISms
{
    /**
     * @return string
     */
    public function getNumber(): string;

    /**
     * @return array
     */
    public function getListNumbers(): array;

    /**
     * @return string
     */
    public function getText(): string;

    /**
     * @return string
     */
    public function getChannel(): string;
}