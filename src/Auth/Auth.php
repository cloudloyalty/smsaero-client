<?php

declare(strict_types=1);

namespace Feech\SmsAero\Auth;


/**
 * Данные для авторизации
 */
class Auth implements IAuth
{
    /**
     * Логин|email
     *
     * @var string
     */
    private $email;
    /**
     * api_key - можно получить по адресу https://smsaero.ru/cabinet/settings/apikey/
     *
     * @var string
     */
    private $password;
    /**
     * Подпись отправителя
     *
     * @var string
     */
    private $sign;

    /**
     * Auth constructor.
     *
     * @param string $email
     * @param string $password
     * @param string $sign
     */
    public function __construct(string $email, string $password, string $sign = 'SMS Aero')
    {
        $this->email = $email;
        $this->password = $password;
        $this->sign = $sign;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @return string
     */
    public function getSign(): string
    {
        return $this->sign;
    }
}