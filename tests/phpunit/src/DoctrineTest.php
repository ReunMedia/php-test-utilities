<?php

declare(strict_types=1);

namespace Reun\TestUtilities;

use Codeception\Specify;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 *
 * @group integration
 * @covers \Reun\TestUtilities\Doctrine
 */
final class DoctrineTest extends TestCase
{
  use Specify;

  public function testCreateEntityManager(): void
  {
    $this->it("should create a configured EntityManager", function () {
      $em = Doctrine::createEntityManager();

      $this->assertInstanceOf(EntityManagerInterface::class, $em);
    });
  }
}
