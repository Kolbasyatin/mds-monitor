<?php

namespace App\Tests\Command;

use App\Command\PlayCheckCommand;
use App\Services\Checker;
use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Exception\RuntimeException;
use Symfony\Component\Console\Tester\CommandTester;

class PlayCheckCommandTest extends KernelTestCase
{
    public function testExecute()
    {
        $kernel = static::createKernel();
        $application = new Application($kernel);

        $checker = $this->createMock(Checker::class);
        $checker
            ->expects($this->exactly(2))
            ->method('check')
            ->willReturnOnConsecutiveCalls(true, false);

        $myApplication = new PlayCheckCommand($checker);
        $application->add($myApplication);

        $command = $application->find('app:play-check');
        $commandTester = new CommandTester($command);
        $commandTester->execute(['source' => 'foo']);
        $output = $commandTester->getDisplay();
        static::assertStringContainsString('Check command was done with status true', trim($output));

        $commandTester->execute(['source' => 'foo']);
        $output = $commandTester->getDisplay();
        static::assertStringContainsString('Check command was done with status false', trim($output));

        static::expectException(RuntimeException::class);
        $commandTester->execute([]);
    }

}
