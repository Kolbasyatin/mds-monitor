<?php

namespace App\Tests\Services;

use App\DecideKeepers\DecideKeeperInterface;
use App\Models\Decision;
use App\Services\DecideStrategyInterface;
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
     * @var DecideStrategyInterface|MockObject
     */
    private $decideStrategy;
    /**
     * @var DecideKeeperInterface|MockObject
     */
    private MockObject $simpleKeeper;

    protected function setUp(): void
    {
        $this->decideStrategy = $this->createStrictMock(DecideStrategyInterface::class);
        $this->simpleKeeper = $this->createStrictMock(DecideKeeperInterface::class);
        $this->decider = new NotifyDecider($this->decideStrategy, $this->simpleKeeper);
    }

    public function testPlayingIsOk(): void
    {
        $this->simpleKeeper
            ->expects(self::once())->method('getNotifyStatus')->with()
            ->willReturn('');
        $this->simpleKeeper
            ->expects(self::once())->method('setNotifyStatus')->with('foo', '1');
        $this->decideStrategy
            ->expects(self::once())->method('decide')->with('')
            ->willReturn(new Decision(false, '1'));
        $this->decider->isNeedNotification('foo');
    }

    public function testNotificationWasSend(): void
    {
        $this->decideStrategy
            ->expects(self::once())->method('lock')
            ->willReturn('lock');
        $this->simpleKeeper
            ->expects(self::once())->method('setNotifyStatus')->with('foo', 'lock');
        $this->decider->notificationWasSend('foo');
    }

    public function testIsNeedNotification(): void
    {
        $this->decideStrategy
            ->expects(self::once())->method('reset')->willReturn('');
        $this->simpleKeeper
            ->expects(self::once())->method('setNotifyStatus')->with('foo', '');
        $this->decider->playingIsOk('foo');
    }
}