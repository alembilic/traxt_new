<?php

namespace App\Http\Middleware;

use App\Entities\User;
use Auth;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

/**
 * Verifies that only admin can access protected routes.
 */
class VerifyAdminAccess
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request HTTP Request
     * @param Closure $next Next middleware handler
     *
     * @return mixed
     *
     * @throws AccessDeniedHttpException
     */
    public function handle(Request $request, Closure $next)
    {
        /**
         * Authenticated user.
         *
         * @var User|null $user
         */
        $user = Auth::user();

        if (!$user) {
            throw new AccessDeniedHttpException();
        }

        if (!$user->isSuperAdmin()) {
            throw new AccessDeniedHttpException();
        }

        return $next($request);
    }
}
