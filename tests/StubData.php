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

    public static function sendToSingleNumberSuccessResponse(): string
    {
        return <<<JSON
{
    "success": true,
    "data": {
        "id": 5,
        "from": "BIZNES",
        "number": "79990000000",
        "text": "Test text",
        "status": 0,
        "extendStatus": "queue",
        "channel": "DIRECT",
        "cost": 2.2,
        "dateCreate": 1532342510,
        "dateSend": 1532342510
    },
    "message": null
}
JSON;
    }

    public static function sendToSingleNumberErrorResponse(): string
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

    public static function sendToMultipleNumbersSuccessResponse(): string
    {
        return <<<JSON
{
    "success": true,
    "data": [
        {
            "id": 5,
            "from": "BIZNES",
            "number": "79990000000",
            "text": "Test text",
            "status": 0,
            "extendStatus": "queue",
            "channel": "DIRECT",
            "cost": 2.2,
            "dateCreate": 1532342510,
            "dateSend": 1532342510
        }
    ],
    "message": null
}
JSON;
    }
}
