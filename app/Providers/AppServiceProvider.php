<?php

namespace App\Providers;

use App\Contracts\IAccountingSystem;
use App\Contracts\IPaymentSystemService;
use App\Core\ChannelManager;
use App\Core\Mail\MailChannel;
use App\Http\Controllers\NotificationsApiController;
use App\Http\Transformers\NotificationTransformer;
use App\Services\Dinero\DineroService;
use App\Services\PaymentServices\QuickPayPaymentServiceService;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\ClientInterface;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Mail\Factory;
use Illuminate\Contracts\Notifications\Dispatcher;
use Illuminate\Mail\Markdown;
use Illuminate\Notifications\ChannelManager as BaseChannelManager;
use Illuminate\Notifications\Channels\MailChannel as BaseMailChannel;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use League\Fractal\TransformerAbstract;
use QuickPay\QuickPay;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->singleton(Dispatcher::class, function (Application $app) {
            return new ChannelManager($app);
        });
        $this->app->singleton(BaseChannelManager::class, function (Application $app) {
            return new ChannelManager($app);
        });

        $this->app->singleton(BaseMailChannel::class, function (Application $app) {
            return new MailChannel($app->make(Factory::class), $app->make(Markdown::class));
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->when(NotificationsApiController::class)
            ->needs(TransformerAbstract::class)
            ->give(NotificationTransformer::class);
        if (!$this->app->environment('local')) {
            URL::forceScheme('https');
        }

        $this->app->bind(ClientInterface::class, GuzzleClient::class);
        $this->app->bind(IAccountingSystem::class, DineroService::class);
        $this->app->bind(IPaymentSystemService::class, QuickPayPaymentServiceService::class);

        $this->app->singleton(QuickPay::class, function () {
            return new QuickPay(':' . config('services.quickPay.secret'));
        });
    }
}
