<?php

namespace App\Tests\MessageHandler;

use App\Message\MonitoringResultMessage;
use App\MessageHandler\TelegramNotificationHandler;
use App\Telegram\TelegramHelper;
use Longman\TelegramBot\Telegram;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class TelegramNotificationHandlerTest extends KernelTestCase
{
    public function testHandler()
    {
        $dummy_api_key = '123456:ABC-DEF1234ghIkl-zyx57W2v1u123ew11';
        $telegram = new Telegram($dummy_api_key, 'bar');
        $helper = $this->createMock(TelegramHelper::class);
        $helper->expects($this->once())->method('getMonitorChatIds')->willReturn([-12345]);
        $service = new TelegramNotificationHandler($telegram, $helper);
        $message = new MonitoringResultMessage('foo', 'bar');
        //** It's enough to know that Telegram Request static method was called */
        define('PHPUNIT_TESTSUITE', true);
        $this->assertTrue($service($message));
    }
}
