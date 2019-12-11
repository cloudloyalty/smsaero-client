SMS Aero V2
===========
Реализует Api v2 для работы с сервисом SMS Aero.

Зависимости
------------

* PHP 7.2 и выше
* [guzzlehttp](https://packagist.org/packages/guzzlehttp/guzzle)

> Можно использовать свою реализацию клиента без использования пакета Guzzle

Установка
------------

Добавить SMS Aero пакет в composer.json:

````json
{
    "require": {
        "ifeech/smsaero-v2": "^1.0"
    }
}
````

Установить пакет:

```bash
$ php composer.phar install ifeech/smsaero-v2
```

Пример работы
--------------


```php
<?php

use Feech\SmsAero\Auth\Auth;
use Feech\SmsAero\Client\ClientGuzzle;
use Feech\SmsAero\SmsAero;
use Feech\SmsAero\Sms\Sms;

$auth = new Auth('email', 'pass');
$client = new ClientGuzzle($auth);

$smsAero = new SmsAero($client);
$sms1 = new Sms('79591234567', 'Тестовое сообщение', SMS::CHANNEL_TYPE_INTERNATIONAL);
$sms2 = new Sms(['79591234567', '79599876543'], 'Тестовое сообщение', SMS::CHANNEL_TYPE_DIGITAL);

try {
    $smsAero->testSend($sms1); // тестовое сообщение
    $smsAero->send($sms1); // отправка сообщения
    $response = $smsAero->bulkSend($sms1); // массовая отправка сообщений

    $responseArray = json_decode($response, true); // ответ в виде ассоциативного массива
} catch (Exception $e) {
    $e->getMessage();
}

```