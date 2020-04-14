<?php

namespace App\Tests\Services;

use App\Message\MonitoringResultMessage;
use App\Message\TextMessageCreator;
use App\Services\Notifier;
use App\Tests\TestCase;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\MessageBusInterface;

use function PHPUnit\Framework\isInstanceOf;

class NotifierTest extends WebTestCase
{
    public function testNotify()
    {
        self::bootKernel();
        $mpdOptions = self::$container->getParameter('app.mpd_client');
        $mCreator = new TextMessageCreator($mpdOptions);
        $message = $mCreator->createMessage('foo');
        $bus = $this->createMock(MessageBusInterface::class);
        $bus
            ->expects($this->once())
            ->method('dispatch')
            ->with(
                $this->callback(function($subject) use ($message) {
                    /** @var  MonitoringResultMessage $subject */
                    $isInstance = $subject instanceof MonitoringResultMessage;
                    $isMessage = $message->getContent() === $subject->getContent();
                    $source = $message->getSource() === 'foo';
                    return $isInstance && $isMessage && $source;
                })
            )
            /** @link https://stackoverflow.com/a/54119269/3725361 */
            ->willReturn(new Envelope($message))
        ;
        $notifier = new Notifier($bus, $mCreator);
        $notifier->notify('foo');
    }
}
