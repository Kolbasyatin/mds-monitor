<?php


namespace App\DecideKeepers;


interface DecideKeeperInterface
{
    public function setNotifyStatus(string $source, string $statusData): void;

    public function getNotifyStatus(string $source): string ;
}