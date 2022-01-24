<?php

namespace App\Contracts;

use App\Notifications\BaseNotification;

/**
 * Contract for all entities which could be notified.
 */
interface INotifiable
{
    /**
     * Returns identifier of notifiable instance.
     *
     * @return integer|null
     */
    public function getId(): ?int;

    /**
     * Add routing information to the channel.
     *
     * @param string $channel Channel to add route information
     * @param string[]|string|null $route Route to add
     *
     * @return void
     */
    public function route(string $channel, $route = null);

    /**
     * Get the notification routing information for the given channel.
     *
     * @param string $channel Channel to get route for
     * @param BaseNotification|null $notification Notification which sending throw given chanel
     *
     * @return string[]|string|null
     */
    public function routeNotificationFor(string $channel, ?BaseNotification $notification = null);

    /**
     * Send the given notification.
     *
     * @param BaseNotification $instance Notification instance to send
     *
     * @return void
     */
    public function notify(BaseNotification $instance): void;

    /**
     * Send the given notification.
     *
     * @param BaseNotification $instance Notification instance to send
     *
     * @return void
     */
    public function notifyNow(BaseNotification $instance): void;
}
