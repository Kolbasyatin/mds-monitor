<?php

declare(strict_types=1);


namespace App\Tests;


use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase as PhpUnitTestCase;

/**
 * https://stackoverflow.com/q/59662396/3725361
 * Class TestCase
 * @package App\Tests
 */
class TestCase extends PhpUnitTestCase
{
    /**
     * Returns a mock object for the specified class.
     *
     * @psalm-template RealInstanceType of object
     * @psalm-param class-string<RealInstanceType> $originalClassName
     * @psalm-return MockObject&RealInstanceType
     * @param string $originalClassName
     * @return MockObject
     */
    protected function createStrictMock(string $originalClassName): MockObject
    {
        return $this->getMockBuilder($originalClassName)
            ->disableOriginalConstructor()
            ->disableOriginalClone()
            ->disableArgumentCloning()
            ->disallowMockingUnknownTypes()
            ->disableAutoReturnValueGeneration()
            ->getMock();
    }
}