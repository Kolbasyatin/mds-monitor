<?php

declare(strict_types=1);


namespace App\Message;


class TextMessageCreator
{
    private array $mpdOptions;

    public function __construct(array $mpdOptions)
    {
        $this->mpdOptions = $mpdOptions;
    }

    public function createMessage(string $source): MonitoringResultMessage
    {
        $text = sprintf(
            'Source %s is not playing.  Host %s, port %d.',
            $source,
            $this->mpdOptions['host'],
            $this->mpdOptions['port']
        );

        return new MonitoringResultMessage($source, $text);
    }
}