<?php

declare(strict_types=1);


namespace App\Services;


use Kolbasyatin\MPD\MPD\Answers\SimpleAnswer;
use Kolbasyatin\MPD\MPD\MPDClient as LibraryClient;
use Kolbasyatin\MPD\MPD\MPDConnection;

class PlayChecker
{
    private LibraryClient $client;

    public function __construct(array $options)
    {
        ['host' => $host, 'port' => $port, 'password' => $password] = $options;
        $connection = new MPDConnection(sprintf('%s:%d', $host, $port));
        $this->client = new LibraryClient($connection, new SimpleAnswer());
    }

    public function isSourcePlaying(): bool
    {
        /** @var SimpleAnswer $answer */
        $answer = $this->client->status();

        return $answer->getStatus() && strtolower($answer->getState()) === 'playing';
    }

}