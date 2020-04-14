<?php

declare(strict_types=1);


namespace App\Message;


class MonitoringResultMessage
{
    private string $content;
    private string $source;

    public function __construct(string $source, string $content)
    {
        $this->content = $content;
        $this->source = $source;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function getSource()
    {
        return $this->source;
    }

}