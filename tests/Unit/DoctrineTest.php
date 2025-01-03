<?php

declare(strict_types=1);

use Doctrine\ORM\EntityManagerInterface;
use Reun\TestUtilities\Doctrine;

describe(Doctrine::class, function () {
    describe("createEntityManager", function () {
        it("should create a configured EntityManager", function () {
            $em = Doctrine::createEntityManager();

            expect($em)->toBeInstanceOf(EntityManagerInterface::class);
        });
    });
});
