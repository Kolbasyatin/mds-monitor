<?php

declare(strict_types=1);


namespace App\Services;


use App\DecideKeepers\DecideKeeperInterface;

class NotifyDecider
{
    /**
     * @var DecideKeeperInterface
     */
    private DecideKeeperInterface $decideKeeper;

    public function __construct(DecideKeeperInterface $decideKeeper)
    {
        $this->decideKeeper = $decideKeeper;
    }

    public function isNeedNotification(string $source): bool
    {
        return !$this->decideKeeper->getNotifyStatus($source);
    }

    public function wasSend(string $source): void
    {
        $this->decideKeeper->setNotifyStatus($source, true);
    }

    public function playIsOk(string $source): void
    {
        $this->decideKeeper->setNotifyStatus($source, false);
    }
}