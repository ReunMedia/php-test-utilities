<?php

declare(strict_types=1);
use Reun\TestUtilities\MockUtilities;

describe(MockUtilities::class, function () {
    describe('mockArrayAccess', function () {
        it(
            "should create a mock that implements an ArrayAccess",
            function () {
                $mock = $this->createStub(ArrayAccess::class);
                $storage = [];

                $storage = MockUtilities::mockArrayAccess($mock, $storage);

                // offsetSet
                $mock["foo"] = "bar";
                $mock->offsetSet("foo2", "bar2");

                expect($storage)->toHaveCount(2);

                // offsetExists
                expect(isset($mock["foo"]))->toBeTrue();
                expect($mock->offsetExists("foo"))->toBeTrue();

                // offsetGet
                expect($mock["foo"])->toEqual("bar");
                expect($mock->offsetGet("foo"))->toEqual("bar");

                // offsetUnset
                unset($mock["foo"]);
                $mock->offsetUnset("foo2");

                expect($storage)->toHaveCount(0);
            }
        );
    });
});
