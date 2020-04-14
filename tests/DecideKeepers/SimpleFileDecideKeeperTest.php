<?php

namespace App\Tests\DecideKeepers;

use App\DecideKeepers\SimpleFileDecideKeeper;
use App\Tests\TestCase;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;

class SimpleFileDecideKeeperTest extends TestCase
{

    public function testNotifyKeep()
    {
        $fileSystem = new Filesystem();
        $fileSystem->remove('/tmp/foo.status.yaml');

        $decider = new SimpleFileDecideKeeper();
        $decider->setNotifyStatus('foo', true);

        $finder = new Finder();
        $files = $finder->files()->name('foo.status.yaml')->in('/tmp');
        static::assertCount(1, $files);

        $status = $decider->getNotifyStatus('foo');
        static::assertTrue($status);
        $decider->setNotifyStatus('foo', false);
        $status = $decider->getNotifyStatus('foo');
        static::assertFalse($status);
    }

    public function testNoFile()
    {
        $fileSystem = new Filesystem();
        $fileSystem->remove('/tmp/foo.status.yaml');
        $decider = new SimpleFileDecideKeeper();
        $status = $decider->getNotifyStatus('foo');
        static::assertFalse($status);
    }
}
