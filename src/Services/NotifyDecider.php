<?php

declare(strict_types=1);


namespace App\Services;


use App\DecideKeepers\DecideKeeperInterface;

class NotifyDecider
{

    private DecideStrategyInterface $decideStrategy;
    /**
     * @var DecideKeeperInterface
     */
    private DecideKeeperInterface $decideKeeper;

    public function __construct(DecideStrategyInterface $decideStrategy, DecideKeeperInterface $decideKeeper)
    {
        $this->decideStrategy = $decideStrategy;
        $this->decideKeeper = $decideKeeper;
    }

    public function isNeedNotification(string $source): bool
    {
        $currentNotifyStatus = $this->decideKeeper->getNotifyStatus($source);
        $decision = $this->decideStrategy->decide($currentNotifyStatus);
        $this->decideKeeper->setNotifyStatus($source, $decision->getDecideInformation());

        return $decision->isDecideIsPositive();
    }

    public function notificationWasSend(string $source): void
    {
        $lockStatus = $this->decideStrategy->lock();
        $this->decideKeeper->setNotifyStatus($source, $lockStatus);
    }

    public function playingIsOk(string $source): void
    {
        $resetStatus = $this->decideStrategy->reset();
        $this->decideKeeper->setNotifyStatus($source, $resetStatus);
    }
}