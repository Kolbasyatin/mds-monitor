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


    public function testDecide()
    {
        $actual = $this->service->decide('');
        $this->assertFalse($actual->isDecideIsPositive());
        $this->assertEquals('1', $actual->getDecideInformation());
        $actual = $this->service->decide($actual->getDecideInformation());
        $this->assertTrue($actual->isDecideIsPositive());
        $this->assertEquals('2', $actual->getDecideInformation());
    }

    public function testDecideIfLock()
    {
        $actual = $this->service->decide('lock');
        $this->assertEquals('lock', $actual->getDecideInformation());
        $this->assertFalse($actual->isDecideIsPositive());
        $actual = $this->service->decide($actual->getDecideInformation());
        $this->assertEquals('lock', $actual->getDecideInformation());
        $this->assertFalse($actual->isDecideIsPositive());
    }

    public function testLock()
    {
        $actual = $this->service->lock('foo');
        $this->assertEquals('lock', $actual);
    }

    public function testReset()
    {
        $actual = $this->service->reset('foo');
        $this->assertEmpty($actual, sprintf('Expected empty, but got %s', $actual));
    }
}
