<?php

namespace App\Tests\Message;

use App\Message\TextMessageCreator;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TextMessageCreatorTest extends WebTestCase
{

    public function testCreateMessage()
    {
        self::bootKernel();
        $options = self::bootKernel()->getContainer()->getParameter('app.mpd_client');
        $mCreator = new TextMessageCreator($options);
        $message = $mCreator->createMessage('foo');
        static::assertNotEmpty($options['host']);
        static::assertNotEmpty($options['port']);
        static::assertStringContainsString($options['host'], $message->getContent());
        static::assertStringContainsString($options['port'], $message->getContent());
        static::assertSame('foo', $message->getSource());
    }
};
