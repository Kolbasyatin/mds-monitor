<?php

declare(strict_types=1);


namespace App\Services\MPD;


use Kolbasyatin\MPD\MPD\Answers\SimpleAnswer;
use Kolbasyatin\MPD\MPD\MPDClient;
use Kolbasyatin\MPD\MPD\MPDConnection;

/**
 * Class MPDClientFactory
 * @package App\Services\MPD
 */
class MPDClientFactory
{
    /**
     * @param array $mpdOptions
     * @return MPDClient
     * @throws \Kolbasyatin\MPD\MPD\Exceptions\MPDConnectionException
     */
    public static function createClient(array $mpdOptions)
    {
        ['host' => $host, 'port' => $port, 'password' => $password] = $mpdOptions;
        $connection = new MPDConnection(sprintf('%s:%d', $host, $port), $password);
        $connection->setSocketTimeOut(5);

        return new MPDClient($connection, new SimpleAnswer());
    }

}