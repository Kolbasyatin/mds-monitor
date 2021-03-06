<?php

namespace App\Tests\Services;

use App\Services\Checker;
use App\Services\Notifier;
use App\Services\NotifyDecider;
use App\Services\PlayStatusChecker;
use App\Tests\TestCase;
use PHPUnit\Framework\MockObject\MockObject;

class CheckerTest extends TestCase
{
    /** @var PlayStatusChecker */
    private MockObject $statusChecker;
    /** @var Notifier */
    private MockObject $notifier;
    /** @var NotifyDecider */
    private MockObject $decider;

    public function setUp (): void
    {
        $this->statusChecker = $this->createStrictMock(PlayStatusChecker::class);
        $this->notifier = $this->createStrictMock(Notifier::class);
        $this->decider = $this->createStrictMock(NotifyDecider::class);
    }

    public function testCheckOk()
    {
        $source = 'foo';

        $this->statusChecker->expects($this->once())->method('isSourcePlaying')->willReturn(true);
        $this->statusChecker->expects($this->never())->method('tryToPlayAgain');
        $this->notifier->expects($this->never())->method('notify');
        $this->decider->expects($this->never())->method('isNeedNotification');
        $this->decider->expects($this->never())->method('notificationWasSend');
        $this->decider->expects($this->once())->method('playingIsOk')->with($source);

        $checker = new Checker($this->statusChecker, $this->notifier, $this->decider);
        static::assertTrue($checker->check($source));
    }

    public function testCheckPlayFail()
    {
        $source = 'foo';

        $this->statusChecker->expects($this->once())->method('isSourcePlaying')->willReturn(false);
        $this->statusChecker->expects($this->once())->method('tryToPlayAgain');
        $this->notifier->expects($this->once())->method('notify')->with($source);
        $this->decider->expects($this->once())->method('isNeedNotification')->with($source)->willReturn(true);
        $this->decider->expects($this->once())->method('notificationWasSend')->with($source);
        $this->decider->expects($this->never())->method('playingIsOk');

        $checker = new Checker($this->statusChecker, $this->notifier, $this->decider);
        static::assertFalse($checker->check($source));
    }

    public function testCheckPlayFailAndAlreadySent()
    {
        $source = 'foo';

        $this->statusChecker->expects($this->once())->method('isSourcePlaying')->willReturn(false);
        $this->statusChecker->expects($this->once())->method('tryToPlayAgain');
        $this->notifier->expects($this->never())->method('notify')->with($source);
        $this->decider->expects($this->once())->method('isNeedNotification')->with($source)->willReturn(false);
        $this->decider->expects($this->never())->method('notificationWasSend');
        $this->decider->expects($this->never())->method('playingIsOk');

        $checker = new Checker($this->statusChecker, $this->notifier, $this->decider);
        static::assertFalse($checker->check($source));
    }

}
