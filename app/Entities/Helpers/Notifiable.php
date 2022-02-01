<?php

namespace App\Entities\Helpers;

use App\Notifications\BaseNotification;
use Illuminate\Contracts\Notifications\Dispatcher;
use Illuminate\Support\Str;

trait Notifiable
{
    /**
     * All of the notification routing information.
     *
     * @var array
     */
    protected $routes = [];

    /**
     * Add routing information to the channel.
     *
     * @param string $channel Channel to add route information
     * @param string|string[]|null $route Route to add
     *
     * @return void
     */
    public function route(string $channel, $route = null): void
    {
        $this->routes[$channel] = $route;
    }

    /**
     * Sends the given notification.
     *
     * @param BaseNotification $instance Base notification instance to notify
     *
     * @return void
     */
    public function notify(BaseNotification $instance): void
    {
        app(Dispatcher::class)->send($this, $instance);
    }

    /**
     * Sends the given notification immediately.
     *
     * @param BaseNotification $instance Base notification instance to notify
     *
     * @return void
     */
    public function notifyNow(BaseNotification $instance): void
    {
        app(Dispatcher::class)->sendNow($this, $instance);
    }

    /**
     * Returns the notification routing information for the given channel.
     *
     * @param string $channel Channel for which needs to return route of notifiable instance
     * @param BaseNotification|null $notification Sending notification instance
     *
     * @return string[]|string|null
     */
    public function routeNotificationFor(string $channel, ?BaseNotification $notification = null)
    {
        if (isset($this->routes[$channel])) {
            return $this->routes[$channel];
        }

        $method = 'routeNotificationFor' . Str::studly($channel);

        if (method_exists($this, $method)) {
            return $this->{$method}($notification);
        }

        switch ($channel) {
            case 'mail':
                return method_exists($this, 'getEmail') ? $this->getEmail() : null;
            default:
                return null;
        }
    }
}
