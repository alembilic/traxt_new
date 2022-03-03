<?php

namespace App\Http\Controllers;

use App\Entities\User;
use Auth;
use Doctrine\Common\Collections\Selectable;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller;
use RuntimeException;

/**
 * Base controller for all api controllers in application.
 *
 * @property-read User|null $user Authenticated user
 */
abstract class BaseWebController extends Controller
{
    use AuthorizesRequests;
    use DispatchesJobs;
    use ValidatesRequests;

    /**
     * Entity manager instance.
     *
     * @var EntityManagerInterface
     */
    protected $entityManager;

    /**
     * Base controller for all api controllers in application.
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
     * @return ObjectRepository|Selectable
     */
    protected function getRepository(string $className): ObjectRepository
    {
        return $this->entityManager->getRepository($className);
    }

    /**
     * Get the authenticated user.
     *
     * @return User|null
     */
    protected function user(): ?User
    {
        return $this->entityManager->getRepository(User::class)->find(Auth::user()->getAuthIdentifier());
    }

    /**
     * Magically handle calls to certain properties.
     *
     * @param string $key Key
     *
     * @return mixed
     *
     * @throws RuntimeException
     */
    public function __get(string $key)
    {
        if ($key === 'user') {
            return $this->user();
        }

        throw new RuntimeException('Undefined property ' . get_class($this) . '::' . $key);
    }
}
