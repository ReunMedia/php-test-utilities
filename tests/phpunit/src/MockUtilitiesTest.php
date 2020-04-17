<?php

declare(strict_types=1);

namespace Reun\TestUtilities;

use ArrayAccess;
use Codeception\Specify;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 *
 * @group unit
 * @covers \Reun\TestUtilities\MockUtilities
 */
final class MockUtilitiesTest extends TestCase
{
  use Specify;

  public function testMockArrayAccess(): void
  {
    $this->it("should create a mock that implements an ArrayAccess", function () {
      $mock = $this->createStub(ArrayAccess::class);
      $storage = [];

      $storage = MockUtilities::mockArrayAccess($mock, $storage);

      // offsetSet
      $mock["foo"] = "bar";
      $mock->offsetSet("foo2", "bar2");

      $this->assertCount(2, $storage);

      // offsetExists
      $this->assertTrue(isset($mock["foo"]));
      $this->assertTrue($mock->offsetExists("foo"));

      // offsetGet
      $this->assertEquals("bar", $mock["foo"]);
      $this->assertEquals("bar", $mock->offsetGet("foo"));

      // offsetUnset
      unset($mock["foo"]);
      $mock->offsetUnset("foo2");

      $this->assertCount(0, $storage);
    });
  }
}
