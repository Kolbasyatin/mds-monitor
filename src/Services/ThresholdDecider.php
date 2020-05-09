<?php

declare(strict_types=1);


namespace App\Services;


use App\DecideKeepers\DecideKeeperInterface;
use App\Models\DecideResult;

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
     * @var int|null
     */
    private int $threshold;


    /**
     * ThresholdDecider constructor.
     * @param int|null $threshold
     */
    public function __construct(?int $threshold = 2)
    {
        $this->threshold = $threshold;
    }

    /**
     * @param string $attempt
     * @return DecideResult
     */
    public function decide(string $attempt): DecideResult
    {
        $isLock = $attempt === self::LOCK_STATUS;
        if ($isLock) {
            $result = new DecideResult(false, $attempt);
        } else {
            $attempt = ++$attempt;
            $isDecidePositive = $attempt >= $this->threshold;
            $result = new DecideResult($isDecidePositive, (string)$attempt);
        }
        return $result;
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