<?php

declare(strict_types=1);


namespace App\Services;


use App\DecideKeepers\DecideKeeperInterface;
use App\Models\Decision;

/**
 * Class ThresholdDecider
 * @package App\Services
 */
class ThresholdDecider implements DecideStrategyInterface
{
    /**
     *
     */
    public const LOCK_STATUS = 'lock';
    /**
     * @var int
     */
    private int $threshold;


    /**
     * ThresholdDecider constructor.
     * @param int $threshold
     */
    public function __construct(int $threshold)
    {
        $this->threshold = $threshold;
    }

    /**
     * @param string $currentStatus
     * @return Decision
     */
    public function decide(string $currentStatus): Decision
    {
        $isLock = $currentStatus === self::LOCK_STATUS;
        if ($isLock) {
            $decision = new Decision(false, $currentStatus);
        } else {
            $attempt = (int)$currentStatus;
            $isDecidePositive = ++$attempt >= $this->threshold;
            $decision = new Decision($isDecidePositive, (string)$attempt);
        }

        return $decision;
    }

    /**
     * @return string
     */
    public function lock(): string
    {
        return static::LOCK_STATUS;
    }

    /**
     * @return string
     */
    public function reset(): string
    {
        return '';
    }


}