<?php

namespace App\Tests\Services;

use App\Services\PlayStatusChecker;
use App\Tests\TestCase;
use Kolbasyatin\MPD\MPD\Answers\SimpleAnswer;
use Kolbasyatin\MPD\MPD\MPDClient;

class PlayStatusCheckerTest extends TestCase
{

    public function testTryToPlayAgain()
    {
        $client = $this->createMock(MPDClient::class);
        $client
            ->expects($this->once())
            ->method('__call')
            ->with(self::stringContains('play'))
        ;
        $checker = new PlayStatusChecker($client);
        $checker->tryToPlayAgain();

    }

    public function testIsSourcePlaying()
    {
        $answer = $this->createMock(SimpleAnswer::class);
        $answer
            ->method('getStatus')
            ->willReturnOnConsecutiveCalls(true, true, false, false)
        ;
        $answer
            ->expects($this->exactly(2))
            ->method('__call')
            ->willReturnOnConsecutiveCalls('playing', 'paused', 'playing');

        $client = $this->createMock(MPDClient::class);
        $client
            ->method('__call')
            ->with(self::stringContains('status'))
            ->willReturn($answer);

        $checker = new PlayStatusChecker($client);
        static::assertTrue($checker->isSourcePlaying(), '1');
        static::assertFalse($checker->isSourcePlaying(), '2');
        static::assertFalse($checker->isSourcePlaying(), '3');
        static::assertFalse($checker->isSourcePlaying(), '4');

    }
}
