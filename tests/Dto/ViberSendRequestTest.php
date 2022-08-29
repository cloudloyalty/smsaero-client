<?php

declare(strict_types=1);

namespace Feech\SmsAeroTest\Dto;

use Feech\SmsAero\Dto\ViberSendRequest;
use PHPUnit\Framework\TestCase;

final class ViberSendRequestTest extends TestCase
{
    public function testFullDataWithSmsCascade(): void
    {
        $request = ViberSendRequest::toSingleNumber('79990000000', 'sign', ViberSendRequest::CHANNEL_CASCADE, 'message')
            ->setImageSource('jpg here', 'jpg')
            ->setTextButton('see more')
            ->setLinkButton('https://your.site')
            ->setDateSend(new \DateTime('2022-08-11 12:00:00', new \DateTimeZone('Europe/Moscow')))
            ->setSignSms('SMS Aero')
            ->setTextSms('sms message')
            ->setPriceSms(10)
            ->setTimeout(0.5);

        $postData = $request->toArray();
        $this->assertEquals(
            [
                'number' => '79990000000',
                'sign' => 'sign',
                'channel' => 'CASCADE',
                'text' => 'message',
                'imageSource' => 'jpg#anBnIGhlcmU=',
                'textButton' => 'see more',
                'linkButton' => 'https://your.site',
                'dateSend' => 1660208400,
                'signSms' => 'SMS Aero',
                'textSms' => 'sms message',
                'priceSms' => 10,
                'timeout' => 0.5,
            ],
            $postData
        );
    }

    public function testMultipleNumbers(): void
    {
        $request = ViberSendRequest::toMultipleNumbers(
            ['79990000000', '79990000001'],
            'sign',
            ViberSendRequest::CHANNEL_INFO,
            'message'
        );
        $request->setImageSource(null, null);
        $request->setDateSend(null);

        $postData = $request->toArray();
        $this->assertEquals(
            [
                'numbers' => ['79990000000', '79990000001'],
                'sign' => 'sign',
                'channel' => 'INFO',
                'text' => 'message',
            ],
            $postData
        );
    }

    public function testGroup(): void
    {
        $request = ViberSendRequest::toGroup('all', 'sign', ViberSendRequest::CHANNEL_OFFICIAL, 'message');

        $postData = $request->toArray();
        $this->assertEquals(
            [
                'groupId' => 'all',
                'sign' => 'sign',
                'channel' => 'OFFICIAL',
                'text' => 'message',
            ],
            $postData
        );

        $request = ViberSendRequest::toGroup(2, 'sign', ViberSendRequest::CHANNEL_OFFICIAL, 'message');

        $postData = $request->toArray();
        $this->assertEquals(
            [
                'groupId' => 2,
                'sign' => 'sign',
                'channel' => 'OFFICIAL',
                'text' => 'message',
            ],
            $postData
        );
    }
}
