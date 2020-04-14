<?php

namespace App\Tests\Services;

use App\DecideKeepers\DecideKeeperInterface;
use App\Services\NotifyDecider;
use App\Tests\TestCase;
use PHPUnit\Framework\MockObject\MockObject;

class NotifyDeciderTest extends TestCase
{

    /**
     * @var NotifyDecider
     */
    private NotifyDecider $decider;
    /**
     * @var DecideKeeperInterface|MockObject
     */
    private $keeper;

    protected function setUp(): void
    {
        $this->keeper = $this->createStrictMock(DecideKeeperInterface::class);
        $this->decider = new NotifyDecider($this->keeper);
    }

    public function testPlayIsOk()
    {
        $this->keeper->expects($this->once())->method('getNotifyStatus')->with('foo');
        $this->decider->isNeedNotification('foo');
    }

    public function testWasSend()
    {
        $this->keeper->expects($this->once())->method('setNotifyStatus')->with('foo', true);
        $this->decider->wasSend('foo');
    }

    public function testIsNeedNotification()
    {
        $this->keeper->expects($this->once())->method('setNotifyStatus')->with('foo', false);
        $this->decider->playIsOk('foo');
    }
}