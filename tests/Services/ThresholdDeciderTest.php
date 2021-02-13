<?php

namespace App\Tests\Services;

use App\Services\DecideStrategyInterface;
use App\Services\ThresholdDecider;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * Class ThresholdDeciderTest
 * @package App\Tests\Services
 */
class ThresholdDeciderTest extends KernelTestCase
{
    private DecideStrategyInterface $service;

    protected function setUp(): void
    {
        self::bootKernel();
        $this->service = self::$container->get(DecideStrategyInterface::class);
    }


    public function testDecide(): void
    {
        $actual = $this->service->decide('');
        self::assertFalse($actual->isDecideIsPositive());
        self::assertEquals('1', $actual->getDecideInformation());
        $actual = $this->service->decide($actual->getDecideInformation());
        self::assertTrue($actual->isDecideIsPositive());
        self::assertEquals('2', $actual->getDecideInformation());
    }

    public function testDecideIfLock(): void
    {
        $actual = $this->service->decide('lock');
        self::assertEquals('lock', $actual->getDecideInformation());
        self::assertFalse($actual->isDecideIsPositive());
        $actual = $this->service->decide($actual->getDecideInformation());
        self::assertEquals('lock', $actual->getDecideInformation());
        self::assertFalse($actual->isDecideIsPositive());
    }

    public function testLock(): void
    {
        $actual = $this->service->lock('foo');
        self::assertEquals('lock', $actual);
    }

    public function testReset(): void
    {
        $actual = $this->service->reset('foo');
        self::assertEmpty($actual, sprintf('Expected empty, but got %s', $actual));
    }
}
