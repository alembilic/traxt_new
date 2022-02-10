<?php

namespace App\Auth;

use App\Core\EntityManagerFresher;
use App\Entities\User;
use Illuminate\Auth\GuardHelpers;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Http\Request;

/**
 * Provider for auth users by using session.
 */
class XAuthTokenGuard implements Guard
{
    use EntityManagerFresher;
    use GuardHelpers;

    /**
     * Header with token in request.
     */
    protected const HEADER_WITH_TOKEN = 'x-auth-token';

    /**
     * Request.
     *
     * @var Request
     */
    protected $request;

    /**
     * Provider for auth users by using `X-AUTH-TOKEN`.
     *
     * @param UserProvider $provider User provider
     * @param Request $request Request
     */
    public function __construct(UserProvider $provider, Request $request)
    {
        $this->provider = $provider;
        $this->request = $request;
    }

    /**
     * {@inheritDoc}
     *
     * @throws BindingResolutionException
     */
    public function user(): ?Authenticatable
    {
        if ($this->user) {
            return $this->user;
        }

        $token = $this->request->header(static::HEADER_WITH_TOKEN);

        if (!$token) {
            return null;
        }

        $user = $this->getEntityManager()->getRepository(User::class)->findOneBy(['apiToken' => $token]);

        if (!$user) {
            return null;
        }

        return $this->user = $user;
    }

    /**
     * {@inheritDoc}
     *
     * @throws BindingResolutionException
     */
    public function validate(array $credentials = []): bool
    {
        if (!isset($credentials[static::HEADER_WITH_TOKEN])) {
            return false;
        }

        return (bool)$this->getEntityManager()
            ->getRepository(User::class)
            ->findOneBy(['apiToken' => $credentials[static::HEADER_WITH_TOKEN]]);
    }
}
