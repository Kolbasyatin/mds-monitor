<?php

namespace App\Tests\Services;

use App\Services\DecideStrategyInterface;
use App\Services\ThresholdDecider;
use PHPUnit\Framework\TestCase;

class ThresholdDeciderTest extends TestCase
{
    private DecideStrategyInterface $service;

    protected function setUp(): void
    {
        $this->service = new ThresholdDecider();
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
