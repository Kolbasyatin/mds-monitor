<?php

namespace App\Tests\Services;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class PlayCheckerTest extends KernelTestCase
{

    public function testIsSourcePlaying()
    {
        self::bootKernel();
        $container = self::$container;
        $checker = $container->get('App\Services\PlayChecker');
        $this->assertTrue($checker->isSourcePlaying());
    }
}
