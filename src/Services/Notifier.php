<?php

declare(strict_types=1);

namespace App\Services;

use App\Message\TextMessageCreator;
use Symfony\Component\Messenger\MessageBusInterface;

class Notifier
{
    /**
     * @var MessageBusInterface
     */
    private MessageBusInterface $bus;
    /**
     * @var TextMessageCreator
     */
    private TextMessageCreator $messageCreator;


    public function __construct(MessageBusInterface $bus, TextMessageCreator $messageCreator)
    {
        $this->bus = $bus;
        $this->messageCreator = $messageCreator;
    }

    public function notify(string $source)
    {
        $message = $this->messageCreator->createMessage($source);
        $this->bus->dispatch($message);
    }
}