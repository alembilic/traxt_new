<?php

namespace App\Core;

use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Contracts\Container\BindingResolutionException;

trait EntityManagerFresher
{
    /**
     * Fresh entity manager if connection was lost in some cases.
     *
     * @return EntityManagerInterface
     *
     * @throws BindingResolutionException
     */
    protected function getEntityManager(): EntityManagerInterface
    {
        $app = app();
        $entityManager = $app->make(EntityManagerInterface::class);
        $connection = $entityManager->getConnection();

        if ($connection->ping() === false) {
            $connection->close();
            $connection->connect();
        }

        if (!$entityManager->isOpen()) {
            $entityManager = $entityManager->create($connection, $entityManager->getConfiguration());
            $app->instance(EntityManagerInterface::class, $entityManager);
        }

        return $entityManager;
    }
}
