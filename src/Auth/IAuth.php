<?php


namespace Feech\SmsAero\Auth;


interface IAuth
{
    /**
     * @return string
     */
    public function getEmail(): string;

    /**
     * @return string
     */
    public function getPassword(): string;

    /**
     * @return string
     */
    public function getSign(): string;
}