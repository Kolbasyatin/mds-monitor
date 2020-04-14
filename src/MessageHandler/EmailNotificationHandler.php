<?php

declare(strict_types=1);


namespace App\MessageHandler;


use App\Message\MonitoringResultMessage;
use Swift_Mailer;
use Swift_Message;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class EmailNotificationHandler implements MessageHandlerInterface
{
    private Swift_Mailer $mailer;
    private array $emailAddresses;

    public function __construct(Swift_Mailer $mailer, array $emailAddreses)
    {
        $this->mailer = $mailer;
        $this->emailAddresses = $emailAddreses;
    }

    public function __invoke(MonitoringResultMessage $message)
    {
        $theme = sprintf(
            'Source %s problem',
            $message->getSource()
        );

        $message = (new Swift_Message($theme))
            ->setTo($this->emailAddresses['receiver'])
            ->setFrom($this->emailAddresses['sender'])
            ->setBody(
                $message->getContent(),
                'text/plain'
            );

        $this->mailer->send($message);
    }
}