<?php

declare(strict_types=1);


namespace App\Services;


class Checker
{
    /**
     * @var PlayStatusChecker
     */
    private PlayStatusChecker $statusChecker;
    /**
     * @var Notifier
     */
    private Notifier $notifier;
    /**
     * @var NotifyDecider
     */
    private NotifyDecider $decider;

    /**
     * Checker constructor.
     * @param PlayStatusChecker $statusChecker
     * @param Notifier $notifier
     * @param NotifyDecider $decider
     */
    public function __construct(PlayStatusChecker $statusChecker, Notifier $notifier, NotifyDecider $decider)
    {
        $this->statusChecker = $statusChecker;
        $this->notifier = $notifier;
        $this->decider = $decider;
    }

    public function check(string $source): bool
    {
        $isSourcePlaying = $this->statusChecker->isSourcePlaying();
        if ($isSourcePlaying) {
            $this->decider->playIsOk($source);
        }
        if (!$isSourcePlaying) {
            $this->notify($source);
            $this->statusChecker->tryToPlayAgain();
        }

        return $isSourcePlaying === true;
    }

    private function notify(string $source)
    {
        if ($this->decider->isNeedNotification($source)) {
            $this->notifier->notify($source);
            $this->decider->wasSend($source);
        }
    }
}