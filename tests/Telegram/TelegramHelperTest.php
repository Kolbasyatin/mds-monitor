<?php

namespace App\Tests\Telegram;

use App\Telegram\TelegramHelper;
use PHPUnit\Framework\TestCase;

class TelegramHelperTest extends TestCase
{

    public function testGetMonitorChatIds()
    {
        $helper = new TelegramHelper();
        $this->assertIsArray($helper->getMonitorChatIds());
    }
}
