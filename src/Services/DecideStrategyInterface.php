<?php


namespace App\Services;


use App\Models\Decision;

interface DecideStrategyInterface
{
    public function decide(string $currentStatus): Decision;
    public function lock(): string;
    public function reset(): string;
}