<?php

namespace App\Tests\MessageHandler;

use App\Message\MonitoringResultMessage;
use App\MessageHandler\EmailNotificationHandler;
use PHPUnit\Framework\TestCase;
use Swift_Mailer;
use Swift_Message;

class EmailNotificationHandlerTest extends TestCase
{
    public function testHandle()
    {
        $mailer = $this->createMock(Swift_Mailer::class);
        $mailer
            ->expects($this->once())
            ->method('send')
            ->with(
                self::isInstanceOf(Swift_Message::class)
            );
        $addresses = [
            'receiver' => 'fake@example.com',
            'sender' => 'fake@example.com'
        ];
        $handler = new EmailNotificationHandler($mailer, $addresses);
        $message = new MonitoringResultMessage('foo', 'bar');
        $handler($message);
    }
}
