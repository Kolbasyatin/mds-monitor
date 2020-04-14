<?php

declare(strict_types=1);


namespace App\Services\MPD;


use Kolbasyatin\MPD\MPD\Answers\SimpleAnswer;
use Kolbasyatin\MPD\MPD\MPDClient;
use Kolbasyatin\MPD\MPD\MPDConnection;

class MPDClientFactory
{
    public static function createClient(array $mpdOptions)
    {
        ['host' => $host, 'port' => $port, 'password' => $password] = $mpdOptions;
        $connection = new MPDConnection(sprintf('%s:%d', $host, $port), $password);

        return new MPDClient($connection, new SimpleAnswer());
    }

}