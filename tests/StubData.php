<?php

declare(strict_types=1);

namespace Feech\SmsAeroTest;

class StubData
{
    public static function authSuccessResponse(): string
    {
        return <<<JSON
{
    "success": true,
    "data": null,
    "message": "Successful authorization."
}
JSON;
    }

    public static function authErrorResponse(): string
    {
        return <<<JSON
{
    "success": false,
    "data": null,
    "message": "Your request was made with invalid credentials."
}
JSON;
    }

    public static function testsendSuccessResponse(): string
    {
        return <<<JSON
{
    "success": true,
    "data": {
        "id": 92756,
        "from": "BIZNES",
        "number": "79990000000",
        "text": "Test text",
        "status": 1,
        "extendStatus": "delivery",
        "channel": "DIRECT",
        "cost": 1.93,
        "dateCreate": 1579266291,
        "dateSend": 1579266291
    },
    "message": null
}
JSON;
    }

    public static function testsendErrorResponse(): string
    {
        return <<<JSON
{
    "success": false,
    "data": {
        "number": ["incorrect"]
    },
    "message": "Validation error."
}
JSON;
    }
}
