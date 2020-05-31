<?php

declare(strict_types=1);


namespace App\Tests\Functional;


use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Tester\CommandTester;

class PlayCheckCommandTest extends KernelTestCase
{
    public function testFunctional()
    {
        $kernel = static::createKernel();
        $application = new Application($kernel);
        $command = $application->find('app:play-check');
        $commandTester = new CommandTester($command);
        $commandTester->execute(['source' => 'foo']);
        $output = $commandTester->getDisplay();
        $this->markTestIncomplete('To implement this test you need to start docker container');
        static::assertSame('Check command was done with status true', trim($output));
    }
}