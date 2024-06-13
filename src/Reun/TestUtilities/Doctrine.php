<?php

declare(strict_types=1);

namespace Reun\TestUtilities;

use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\ORMSetup;
use Doctrine\ORM\Tools\SchemaTool;

class Doctrine
{
    public static function createEntityManager(
        array $withSchemaClasses = [],
        array $connection = [
            "driver" => "sqlite3",
            "memory" => true,
        ],
        array $paths = ["../../../src/"],
        bool $recreateSchema = true,
    ): EntityManagerInterface {
        $connection = DriverManager::getConnection($connection);

        $doctrineConfig = ORMSetup::createAttributeMetadataConfiguration(
            $paths,
            true
        );

        $em = new EntityManager($connection, $doctrineConfig);

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
