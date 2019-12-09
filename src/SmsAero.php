<?php

namespace Feech\SmsAero;

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
     * @return array
     * @throws \Exception
     */
    public function auth(): array
    {
        return $this->client->requestArray('/auth');
    }

    /**
     * Карты пользователя
     *
     * @return array
     * @throws \Exception
     */
    public function cards(): array
    {
        return $this->client->requestArray('/cards');
    }

    /**
     * Пополнение баланса
     *
     * @param int $sum Сумма пополнения
     * @param int $cardId Идентификационный номер карты
     *
     * @return array
     * @throws \Exception
     */
    public function addBalance(int $sum, int $cardId): array
    {
        return $this->client->requestArray('/balance/add', [
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
     * @return array
     * @throws \Exception
     */
    public function send(ISms $sms, string $sign = '', int $dateSend = null, string $callbackUrl = null): array
    {
        return $this->client->requestArray('/sms/send', [
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
     * @return array
     * @throws \Exception
     */
    public function testSend(ISms $sms, string $sign = 'SMS Aero', int $dateSend = null, string $callbackUrl = null): array
    {
        return $this->client->requestArray('/sms/testsend', [
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
     * @return array
     * @throws \Exception
     */
    public function bulkSend(ISms $sms, string $sign = '', int $dateSend = null, string $callbackUrl = null): array
    {
        return $this->client->requestArray('/sms/send', [
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
     * @return array
     * @throws \Exception
     */
    public function checkSend(int $id): array
    {
        return $this->client->requestArray('/sms/status', [
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
     * @return array
     * @throws \Exception
     */
    public function smsList(string $number = null, string $text = null, int $page = 1): array
    {
        return $this->client->requestArray('/sms/list', [
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
     * @return array
     * @throws \Exception
     */
    public function testSmsList(string $number = null, string $text = null, int $page = 1): array
    {
        return $this->client->requestArray('/sms/testlist', [
            'page'   => $page,
            'number' => $number,
            'text'   => $text
        ]);
    }

    /**
     * Запрос баланса
     *
     * @return array
     * @throws \Exception
     */
    public function balance(): array
    {
        return $this->client->requestArray('/balance');
    }

    /**
     * Запрос тарифа
     *
     * @return array
     * @throws \Exception
     */
    public function tariffs(): array
    {
        return $this->client->requestArray('/tariffs');
    }

    /**
     * Добавление в чёрный список
     *
     * @param string $number Номер абонента
     *
     * @return array
     * @throws \Exception
     */
    public function blacklistAdd(string $number): array
    {
        return $this->client->requestArray('/blacklist/add', [
            'number' => $number
        ]);
    }

    /**
     * Удаление из черного списка
     *
     * @param int $id Идентификатор абонента
     *
     * @return array
     * @throws \Exception
     */
    public function blacklistDelete($id): array
    {
        return $this->client->requestArray('/blacklist/delete', [
            'id' => $id
        ]);
    }

    /**
     * Список контактов в черном списке
     *
     * @param null|string $number Номер абонента
     * @param int         $page Пагинация
     *
     * @return array
     * @throws \Exception
     */
    public function blacklistList(string $number = null, int $page = 1): array
    {
        return $this->client->requestArray('/blacklist/list', [
            'page'   => $page,
            'number' => $number
        ]);
    }

    /**
     * Определение оператора
     *
     * @param string $number Номер абонента
     *
     * @return array
     * @throws \Exception
     */
    public function operatorNumber(string $number): array
    {
        return $this->client->requestArray('/number/operator', [
            'number' => $number
        ]);
    }
}