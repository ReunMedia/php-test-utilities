<?php

declare(strict_types=1);

namespace Reun\TestUtilities;

use PHPUnit\Framework\MockObject\Stub;

/**
 * Utilites to enhance mocks.
 */
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
            ->willReturnCallback(function ($key) use (&$storage) {
                return isset($storage[$key]);
            })
        ;
        $mock->method("offsetGet")
            ->willReturnCallback(function ($key) use (&$storage) {
                return $storage[$key] ?? null;
            })
        ;
        $mock->method("offsetSet")
            ->willReturnCallback(function ($key, $val) use (&$storage) {
                $storage[$key] = $val;
            })
        ;
        $mock->method("offsetUnset")
            ->willReturnCallback(function ($key) use (&$storage) {
                unset($storage[$key]);
            })
        ;

        return $storage;
    }
}
