<?php

namespace App\Providers;

use App\Core\ChannelManager;
use App\Core\Mail\MailChannel;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Mail\Factory;
use Illuminate\Contracts\Notifications\Dispatcher;
use Illuminate\Mail\Markdown;
use Illuminate\Notifications\ChannelManager as BaseChannelManager;
use Illuminate\Notifications\Channels\MailChannel as BaseMailChannel;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

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
        //
    }
}
