<?php


namespace App\Services;


use App\Models\DecideResult;

interface DecideStrategyInterface
{
    public function decide(string $data): DecideResult;
    public function lock(): string;
    public function reset(): string;
}