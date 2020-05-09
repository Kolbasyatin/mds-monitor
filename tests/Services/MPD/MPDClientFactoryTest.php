<?php

namespace App\Tests\Services\MPD;

use App\Services\MPD\MPDClientFactory;
use Kolbasyatin\MPD\MPD\MPDClient;
use PHPUnit\Framework\TestCase;

class MPDClientFactoryTest extends TestCase
{

    public function testCreateClient()
    {
        $config = [
            'host' => 'foo',
            'port' => 6100,
            'password' => 'bar',
            'timeout' => 2
        ];
        $mpdClient = MPDClientFactory::createClient($config);

        static::assertInstanceOf(MPDClient::class, $mpdClient);
    }
}
