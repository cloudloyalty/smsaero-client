<?php

namespace Feech\SmsAero;


use Exception;
use Feech\SmsAero\Sms\ISms;
use Feech\SmsAero\Client\IClient;

class SmsAero
{
    /**
     * @var IClient
     */
    private $client;

    /**
     * SmsAero constructor.
     *
     * @param IClient $client
     */
    public function __construct(IClient $client)
    {
        $this->client = $client;
    }

    /**
     * Тестовый метод, для проверки авторизации пользователя
     *
     * @return string
     * @throws Exception
     */
    public function auth(): string
    {
        return $this->client->request('/auth');
    }

    /**
     * Карты пользователя
     *
     * @return string
     * @throws Exception
     */
    public function cards(): string
    {
        return $this->client->request('/cards');
    }

    /**
     * Пополнение баланса
     *
     * @param int $sum Сумма пополнения
     * @param int $cardId Идентификационный номер карты
     *
     * @return string
     * @throws Exception
     */
    public function addBalance(int $sum, int $cardId): string
    {
        return $this->client->request('/balance/add', [
            'sum'    => $sum,
            'cardId' => $cardId
        ]);
    }

    /**
     * Отправка сообщения
     *
     * @param ISms        $sms
     * @param string      $sign
     * @param int|null    $dateSend Дата для отложенной отправки сообщения (в формате unixtime)
     * @param string|null $callbackUrl url для отправки статуса сообщения в формате http(s)://your.site
     * (в ответ система ждет статус 200)
     *
     * @return string
     * @throws Exception
     */
    public function send(ISms $sms, string $sign = '', int $dateSend = null, string $callbackUrl = null): string
    {
        return $this->client->request('/sms/send', [
            'number'      => $sms->getNumber(),
            'text'        => $sms->getText(),
            'channel'     => $sms->getChannel(),
            'sign'        => $sign,
            'dateSend'    => $dateSend,
            'callbackUrl' => $callbackUrl
        ]);
    }

    /**
     * Отправка ТЕСТОВОГО сообщения
     *
     * @param ISms        $sms
     * @param string      $sign
     * @param int|null    $dateSend Дата для отложенной отправки сообщения (в формате unixtime)
     * @param string|null $callbackUrl url для отправки статуса сообщения в формате http(s)://your.site
     * (в ответ система ждет статус 200)
     *
     * @return string
     * @throws Exception
     */
    public function testSend(ISms $sms, string $sign = 'SMS Aero', int $dateSend = null, string $callbackUrl = null): string
    {
        return $this->client->request('/sms/testsend', [
            'number'      => $sms->getNumber(),
            'text'        => $sms->getText(),
            'channel'     => $sms->getChannel(),
            'sign'        => $sign,
            'dateSend'    => $dateSend,
            'callbackUrl' => $callbackUrl
        ]);
    }

    /**
     * Отправка массовых сообщений
     *
     * @param ISms        $sms
     * @param string      $sign
     * @param int|null    $dateSend Дата для отложенной отправки сообщения (в формате unixtime)
     * @param string|null $callbackUrl url для отправки статуса сообщения в формате http(s)://your.site
     * (в ответ система ждет статус 200)
     *
     * @return string
     * @throws Exception
     */
    public function bulkSend(ISms $sms, string $sign = '', int $dateSend = null, string $callbackUrl = null): string
    {
        return $this->client->request('/sms/send', [
            'numbers'     => $sms->getListNumbers(),
            'text'        => $sms->getText(),
            'channel'     => $sms->getChannel(),
            'sign'        => $sign,
            'dateSend'    => $dateSend,
            'callbackUrl' => $callbackUrl
        ]);
    }

    /**
     * Проверка статуса SMS сообщения
     *
     * @param int $id Идентификатор сообщения
     *
     * @return string
     * @throws Exception
     */
    public function checkSend(int $id): string
    {
        return $this->client->request('/sms/status', [
            'id' => $id
        ]);
    }

    /**
     * Получение списка отправленных sms сообщений
     *
     * @param string $number Фильтровать сообщения по номеру телефона
     * @param string $text Фильтровать сообщения по тексту
     * @param int    $page Номер страницы
     *
     * @return string
     * @throws Exception
     */
    public function smsList(string $number = null, string $text = null, int $page = 1): string
    {
        return $this->client->request('/sms/list', [
            'page'   => $page,
            'number' => $number,
            'text'   => $text
        ]);
    }

    /**
     * Получение ТЕСТОВОГО списка отправленных sms сообщений
     *
     * @param string $number Фильтровать сообщения по номеру телефона
     * @param string $text Фильтровать сообщения по тексту
     * @param int    $page Номер страницы
     *
     * @return string
     * @throws Exception
     */
    public function testSmsList(string $number = null, string $text = null, int $page = 1): string
    {
        return $this->client->request('/sms/testlist', [
            'page'   => $page,
            'number' => $number,
            'text'   => $text
        ]);
    }

    /**
     * Запрос баланса
     *
     * @return string
     * @throws Exception
     */
    public function balance(): string
    {
        return $this->client->request('/balance');
    }

    /**
     * Запрос тарифа
     *
     * @return string
     * @throws Exception
     */
    public function tariffs(): string
    {
        return $this->client->request('/tariffs');
    }

    /**
     * Добавление в чёрный список
     *
     * @param string $number Номер абонента
     *
     * @return string
     * @throws Exception
     */
    public function blacklistAdd(string $number): string
    {
        return $this->client->request('/blacklist/add', [
            'number' => $number
        ]);
    }

    /**
     * Удаление из черного списка
     *
     * @param int $id Идентификатор абонента
     *
     * @return string
     * @throws Exception
     */
    public function blacklistDelete($id): string
    {
        return $this->client->request('/blacklist/delete', [
            'id' => $id
        ]);
    }

    /**
     * Список контактов в черном списке
     *
     * @param null|string $number Номер абонента
     * @param int         $page Пагинация
     *
     * @return string
     * @throws Exception
     */
    public function blacklistList(string $number = null, int $page = 1): string
    {
        return $this->client->request('/blacklist/list', [
            'page'   => $page,
            'number' => $number
        ]);
    }

    /**
     * Определение оператора
     *
     * @param string $number Номер абонента
     *
     * @return string
     * @throws Exception
     */
    public function operatorNumber(string $number): string
    {
        return $this->client->request('/number/operator', [
            'number' => $number
        ]);
    }
}