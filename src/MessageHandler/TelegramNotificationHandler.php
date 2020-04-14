<?php

declare(strict_types=1);


namespace App\MessageHandler;


use App\Message\MonitoringResultMessage;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class TelegramNotificationHandler implements MessageHandlerInterface
{
    public function __invoke(MonitoringResultMessage $message)
    {
        $message = $message->getContent();
    }
}