<?php

namespace App\Services;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;

/**
 * Base service with common methods.
 */
abstract class BaseService
{
    /**
     * Entity manager instance.
     *
     * @var EntityManagerInterface
     */
    protected EntityManagerInterface $entityManager;

    /**
     * Base service with common methods.
     *
     * @param EntityManagerInterface $entityManager Entity manager instance
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * Return repository from entity manager.
     *
     * @param string $className Class to get repository
     *
     * @return ObjectRepository
     */
    protected function getRepository(string $className): ObjectRepository
    {
        return $this->entityManager->getRepository($className);
    }
}
