<?php

declare(strict_types=1);

namespace Reun\TestUtilities;

use Doctrine\Common\Annotations\AnnotationRegistry;
use Doctrine\DBAL\Logging\EchoSQLLogger;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\SchemaTool;
use Doctrine\ORM\Tools\Setup;

class Doctrine
{
  public static function createEntityManager(array $withSchemaClasses = [], array $connection = ["url" => "sqlite:///:memory:"], bool $recreateSchema = true, bool $logging = false): EntityManagerInterface
  {
    // Initialize AnnotationRegistry loader
    AnnotationRegistry::registerLoader("class_exists");

    $paths = ["../../../src/"];
    $config = Setup::createAnnotationMetadataConfiguration($paths, true, null, null, false);
    $logging && $config->setSQLLogger(new EchoSQLLogger());

    $em = EntityManager::create($connection, $config);

    if ($withSchemaClasses) {
      $schemaTool = new SchemaTool($em);
      $classesMetadata = [];
      foreach ($withSchemaClasses as $classname) {
        $classesMetadata[] = $em->getClassMetadata($classname);
      }
      // Drop and recreate schema.
      if ($recreateSchema) {
        $schemaTool->dropSchema($classesMetadata);
        $schemaTool->createSchema($classesMetadata);
      }
    }

    return $em;
  }
}
