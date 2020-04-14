<?php

declare(strict_types=1);


namespace App\Services;

use Kolbasyatin\MPD\MPD\Answers\SimpleAnswer;
use Kolbasyatin\MPD\MPD\MPDClient;

class PlayStatusChecker
{
    private MPDClient $client;

    public function __construct(MPDClient $client)
    {
        $this->client = $client;
    }

    public function isSourcePlaying(): bool
    {
        /** @var SimpleAnswer $answer */
        $answer = $this->client->status();

        return $answer->getStatus() && strtolower($answer->getState()) === 'playing';
    }

    public function tryToPlayAgain(): void
    {
        $this->client->play();
    }

}