<?php

namespace App\Providers;

use App\Auth\XAuthTokenGuard;
use App\Entities\BackLink;
use App\Entities\Domain;
use App\Policies\BasePolicy;
use Illuminate\Contracts\Container\Container;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Auth;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Domain::class => BasePolicy::class,
        BackLink::class => BasePolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Auth::extend('xAuth', function (Container $container, string $name, array $config) {
            return new XAuthTokenGuard(Auth::createUserProvider($config['provider']), $container->make('request'));
        });
    }
}
