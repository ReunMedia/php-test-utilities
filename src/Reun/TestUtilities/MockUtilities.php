<?php

declare(strict_types=1);

namespace Reun\TestUtilities;

use PHPUnit\Framework\TestCase;

class MockUtilities
{
    public static function &mockArrayAccess($mock, array &$storage): array
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
