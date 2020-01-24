SMS Aero V2
===========

![](https://github.com/ifeech/smsaero-v2/workflows/test/badge.svg)

Реализует Api v2 для работы с сервисом SMS Aero.

Зависимости
------------

* PHP 7.2 и выше
* [guzzlehttp](https://packagist.org/packages/guzzlehttp/guzzle)

> Можно использовать свою реализацию клиента без использования пакета Guzzle

Установка
------------

```bash
$ php composer.phar require ifeech/smsaero-v2
```

Пример работы
--------------


```php
<?php

use Feech\SmsAero\Auth\Auth;
use Feech\SmsAero\Client\ClientGuzzle;
use Feech\SmsAero\Exception\BaseSmsAeroException;
use Feech\SmsAero\SmsAero;
use Feech\SmsAero\Sms\Sms;

$auth = new Auth('email', 'pass');
$client = new ClientGuzzle($auth);

$smsAero = new SmsAero($client);
$sms1 = new Sms('79591234567', 'Тестовое сообщение', Sms::CHANNEL_TYPE_INTERNATIONAL);
$sms2 = new Sms(['79591234567', '79599876543'], 'Тестовое сообщение', Sms::CHANNEL_TYPE_DIGITAL);

try {
    $smsAero->testSend($sms1); // тестовое сообщение
    $smsAero->send($sms1); // отправка сообщения
    $response = $smsAero->bulkSend($sms1); // массовая отправка сообщений

    $responseArray = json_decode($response, true); // ответ в виде ассоциативного массива
} catch (BaseSmsAeroException $e) {
    $e->getMessage();
}

```

### Настройка guzzle адаптера

```php
use Feech\SmsAero\Auth\Auth;
use Feech\SmsAero\Client\ClientGuzzle;
use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;

// configure required handler, middleware:
$handlerStack = HandlerStack::create();

$guzzleClient = new Client([
    'connect_timeout' => 5,
    'timeout' => 5,
    'handler' => $handlerStack,
]);

$auth = new Auth('email', 'pass');
$client = new ClientGuzzle($auth, $guzzleClient);
```


### Десериализация ответов в DTO

Для работы с ответами сервиса через DTO используется jms/serializer и отдельный класс клиента SmsAeroClient.

```php
use Feech\SmsAero\Auth\Auth;
use Feech\SmsAero\Client\ClientGuzzle;
use Feech\SmsAero\Sms\Sms;
use Feech\SmsAero\SmsAeroClient;
use JMS\Serializer\SerializerBuilder;

$auth = new Auth('email', 'pass');
$client = new ClientGuzzle($auth);
$serializer = SerializerBuilder::create()->build();

$smsAero = new SmsAeroClient($client, $serializer);

$sms = Sms::toSingleNumber('79591234567', 'Тестовое сообщение', Sms::CHANNEL_TYPE_INTERNATIONAL);

$result = $smsAero->send($sms);
var_dump($result->data->status);
var_dump($result->data->cost);
```
