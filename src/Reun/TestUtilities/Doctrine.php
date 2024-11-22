<?php

declare(strict_types=1);

namespace Reun\TestUtilities;

use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\ORMSetup;
use Doctrine\ORM\Tools\SchemaTool;

/**
 * Doctrine testing utilites.
 *
 * @phpstan-import-type Params from DriverManager
 */
class Doctrine
{
    /**
     * Create an in-memory SQLite EntityManager with specified classes.
     *
     * @param array<class-string|string> $withSchemaClasses Entity classes that the EM manages
     * @param Params                     $connection        Doctrine connection parameters
     * @param array<string>              $paths             Paths to entitites
     * @param bool                       $recreateSchema    If true, forces recreation of the DB
     *                                                      schema
     */
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

        if ([] !== $withSchemaClasses) {
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
