<?php

namespace App\Http\Middleware;

use App\Core\EntityManagerFresher;
use App\Entities\User;
use Closure;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class CheckUserPlan
{
    use EntityManagerFresher;

    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @param string|null ...$guards
     * @return Response|RedirectResponse
     * @throws BindingResolutionException
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        /* @var User $user */
        $user = $this->getEntityManager()->find(User::class, Auth::user()->__get('id'));

        if ($user->getPlan() === '315e6de73efddbaa5f3d520daf1f8a9e' && !$user->isActivePlan() && $request->path() != 'app/myplanbeta') {
            return redirect('/app/myplanbeta');
        }
        if (!$user->isActivePlan() && $request->path() != 'app/myplanbeta') {
            return redirect('/app/plans?cancelpayment=1');
        }

        return $next($request);
    }
}
