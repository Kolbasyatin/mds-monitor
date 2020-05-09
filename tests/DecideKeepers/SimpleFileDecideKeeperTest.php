<?php

namespace App\Tests\DecideKeepers;

use App\DecideKeepers\SimpleFileDecideKeeper;
use App\Tests\TestCase;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;

class SimpleFileDecideKeeperTest extends TestCase
{

    /** @dataProvider decideData
     * @param string $data
     */
    public function testNotifyKeep(string $status): void
    {
        $fileSystem = new Filesystem();
        $fileSystem->remove('/tmp/foo.status.yaml');

        $decider = new SimpleFileDecideKeeper();
        $decider->setNotifyStatus('foo', $status);

        $finder = new Finder();
        $files = $finder->files()->name('foo.status.yaml')->in('/tmp');
        static::assertCount(1, $files);

        $actual = $decider->getNotifyStatus('foo');
        static::assertEquals((int)$status, (int)$actual);
    }

    public function decideData(): array
    {
        return [
            ['1'],
            ['2'],
            ['3'],
            [(string)false],
            ['lock']
        ];
    }

    public function testNoFile()
    {
        $fileSystem = new Filesystem();
        $fileSystem->remove('/tmp/foo.status.yaml');
        $decider = new SimpleFileDecideKeeper();
        $status = $decider->getNotifyStatus('foo');
        static::assertEmpty($status);
    }
}
