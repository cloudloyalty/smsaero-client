<?php

declare(strict_types=1);

namespace Feech\SmsAero;

use Feech\SmsAero\Exception\BadResponseException;
use Feech\SmsAero\Exception\BaseSmsAeroException;
use Feech\SmsAero\Client\IClient;
use Feech\SmsAero\Sms\ISms;
use JMS\Serializer\Exception\RuntimeException;
use JMS\Serializer\SerializerInterface;

class SmsAeroClient
{
    /** @var SmsAero */
    private $rawJsonClient;

    /** @var SerializerInterface */
    private $serializer;

    public function __construct(IClient $client, SerializerInterface $serializer)
    {
        $this->rawJsonClient = new SmsAero($client);
        $this->serializer = $serializer;
    }

    /**
     * Тестовый метод, для проверки авторизации пользователя
     *
     * @return Dto\AuthResponse
     * @throws BaseSmsAeroException
     */
    public function auth(): Dto\AuthResponse
    {
        try {
            $jsonResponse = $this->rawJsonClient->auth();

            $result = $this->serializer->deserialize(
                $jsonResponse,
                Dto\AuthResponse::class,
                'json'
            );
            assert($result instanceof Dto\AuthResponse);
        } catch (RuntimeException $e) {
            throw BadResponseException::becauseOfDeserializationError($e);
        }

        return $result;
    }

    /**
     * Карты пользователя
     *
     * @return string
     * @throws BaseSmsAeroException
     */
    //public function cards(): string

    /**
     * Пополнение баланса
     *
     * @param int $sum Сумма пополнения
     * @param int $cardId Идентификационный номер карты
     *
     * @return string
     * @throws BaseSmsAeroException
     */
    //public function addBalance(int $sum, int $cardId): string

    /**
     * Отправка сообщения
     *
     * @param ISms        $sms
     * @param string      $sign
     * @param int|null    $dateSend Дата для отложенной отправки сообщения (в формате unixtime)
     * @param string|null $callbackUrl url для отправки статуса сообщения в формате http(s)://your.site
     * (в ответ система ждет статус 200)
     *
     * @return Dto\SendSingleMessageResponse
     * @throws BaseSmsAeroException
     * @throws \InvalidArgumentException
     */
    public function send(
        ISms $sms,
        string $sign = '',
        int $dateSend = null,
        string $callbackUrl = null
    ): Dto\SendSingleMessageResponse {
        try {
            $jsonResponse = $this->rawJsonClient->send($sms, $sign, $dateSend, $callbackUrl);

            $result = $this->serializer->deserialize(
                $jsonResponse,
                Dto\SendSingleMessageResponse::class,
                'json'
            );
            assert($result instanceof Dto\SendSingleMessageResponse);
        } catch (RuntimeException $e) {
            throw BadResponseException::becauseOfDeserializationError($e);
        }

        return $result;
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
     * @return Dto\SendBulkMessageResponse
     * @throws BaseSmsAeroException
     * @throws \InvalidArgumentException
     */
    public function bulkSend(
        ISms $sms,
        string $sign = '',
        int $dateSend = null,
        string $callbackUrl = null
    ): Dto\SendBulkMessageResponse {
        try {
            $jsonResponse = $this->rawJsonClient->bulkSend($sms, $sign, $dateSend, $callbackUrl);

            $result = $this->serializer->deserialize(
                $jsonResponse,
                Dto\SendBulkMessageResponse::class,
                'json'
            );
            assert($result instanceof Dto\SendBulkMessageResponse);
        } catch (RuntimeException $e) {
            throw BadResponseException::becauseOfDeserializationError($e);
        }

        return $result;
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
     * @return Dto\SendSingleMessageResponse
     * @throws BaseSmsAeroException
     * @throws \InvalidArgumentException
     */
    public function testSend(
        ISms $sms,
        string $sign = 'SMS Aero',
        int $dateSend = null,
        string $callbackUrl = null
    ): Dto\SendSingleMessageResponse {
        try {
            $jsonResponse = $this->rawJsonClient->testSend($sms, $sign, $dateSend, $callbackUrl);

            $result = $this->serializer->deserialize(
                $jsonResponse,
                Dto\SendSingleMessageResponse::class,
                'json'
            );
            assert($result instanceof Dto\SendSingleMessageResponse);
        } catch (RuntimeException $e) {
            throw BadResponseException::becauseOfDeserializationError($e);
        }

        return $result;
    }

    /**
     * Проверка статуса SMS сообщения
     *
     * @param int $id Идентификатор сообщения
     *
     * @return string
     * @throws BaseSmsAeroException
     */
    //public function checkSend(int $id): string

    /**
     * Получение списка отправленных sms сообщений
     *
     * @param string $number Фильтровать сообщения по номеру телефона
     * @param string $text Фильтровать сообщения по тексту
     * @param int    $page Номер страницы
     *
     * @return string
     * @throws BaseSmsAeroException
     */
    //public function smsList(string $number = null, string $text = null, int $page = 1): string

    /**
     * Получение ТЕСТОВОГО списка отправленных sms сообщений
     *
     * @param string $number Фильтровать сообщения по номеру телефона
     * @param string $text Фильтровать сообщения по тексту
     * @param int    $page Номер страницы
     *
     * @return string
     * @throws BaseSmsAeroException
     */
    //public function testSmsList(string $number = null, string $text = null, int $page = 1): string

    /**
     * Запрос баланса
     *
     * @return string
     * @throws BaseSmsAeroException
     */
    //public function balance(): string

    /**
     * Запрос тарифа
     *
     * @return string
     * @throws BaseSmsAeroException
     */
    //public function tariffs(): string

    /**
     * Добавление в чёрный список
     *
     * @param string $number Номер абонента
     *
     * @return string
     * @throws BaseSmsAeroException
     */
    //public function blacklistAdd(string $number): string

    /**
     * Удаление из черного списка
     *
     * @param int $id Идентификатор абонента
     *
     * @return string
     * @throws BaseSmsAeroException
     */
    //public function blacklistDelete($id): string

    /**
     * Список контактов в черном списке
     *
     * @param null|string $number Номер абонента
     * @param int         $page Пагинация
     *
     * @return string
     * @throws BaseSmsAeroException
     */
    //public function blacklistList(string $number = null, int $page = 1): string

    /**
     * Определение оператора
     *
     * @param string $number Номер абонента
     *
     * @return string
     * @throws BaseSmsAeroException
     */
    //public function operatorNumber(string $number): string
}
