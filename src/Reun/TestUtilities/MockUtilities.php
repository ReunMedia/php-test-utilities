<?php

declare(strict_types=1);

namespace Reun\TestUtilities;

use PHPUnit\Framework\MockObject\Stub;
use PHPUnit\Framework\TestCase;

class MockUtilities
{
    /**
     * @param array<mixed> $storage
     *
     * @return array<mixed>
     */
    public static function &mockArrayAccess(Stub $mock, array &$storage): array
    {
        $mock->method("offsetExists")
            ->will(TestCase::returnCallback(function ($key) use (&$storage) {
                return isset($storage[$key]);
            }))
        ;
        $mock->method("offsetGet")
            ->will(TestCase::returnCallback(function ($key) use (&$storage) {
                return $storage[$key] ?? null;
            }))
        ;
        $mock->method("offsetSet")
            ->will(TestCase::returnCallback(function ($key, $val) use (&$storage) {
                $storage[$key] = $val;
            }))
        ;
        $mock->method("offsetUnset")
            ->will(TestCase::returnCallback(function ($key) use (&$storage) {
                unset($storage[$key]);
            }))
        ;

        return $storage;
    }
}
