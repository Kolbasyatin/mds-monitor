<?php


namespace App\DecideKeepers;


interface DecideKeeperInterface
{
    public function setNotifyStatus(string $source, bool $status): void;

    public function getNotifyStatus(string $source): bool;
}