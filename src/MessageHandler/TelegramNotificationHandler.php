<?php

declare(strict_types=1);


namespace App\MessageHandler;


use App\Message\MonitoringResultMessage;
use App\Telegram\TelegramHelper;
use Longman\TelegramBot\Exception\TelegramException;
use Longman\TelegramBot\Request;
use Longman\TelegramBot\Telegram;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class TelegramNotificationHandler implements MessageHandlerInterface
{
    private Telegram $telegram;
    /**
     * @var TelegramHelper
     */
    private TelegramHelper $helper;

    public function __construct(Telegram $telegram, TelegramHelper $helper)
    {
        $this->telegram = $telegram;
        $this->helper = $helper;
    }


    /**
     * @param MonitoringResultMessage $message
     * @return bool
     * @throws TelegramException
     */
    public function __invoke(MonitoringResultMessage $message): bool
    {
        $message = $message->getContent();
        foreach ($this->helper->getMonitorChatIds() as $chatId) {
            $response = Request::sendMessage(
                [
                    'chat_id' => $chatId,
                    'text' => $message
                ]
            );
        }

        return true;
    }
}