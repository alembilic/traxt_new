<?php

namespace App\Core;

use App\Contracts\INotifiable;
use Illuminate\Notifications\NotificationSender as BaseNotificationSender;
use Illuminate\Support\Str;

class NotificationSender extends BaseNotificationSender
{
    /**
     * {@inheritDoc}
     */
    protected function sendToNotifiable($notifiable, $id, $notification, $channel)
    {
        if (!$notification->id) {
            $notification->id = $id;
        }

        if (!$this->shouldSendNotification($notifiable, $notification, $channel)) {
            return;
        }

        $response = $this->manager->driver($channel)->send($notifiable, $notification);

        $this->events->dispatch(new NotificationSent($notifiable, $notification, $channel, $response));
    }

    /**
     * {@inheritDoc}
     */
    protected function queueNotification($notifiables, $notification)
    {
        $notifiables = $this->formatNotifiables($notifiables);

        $original = clone $notification;

        /**
         * List of entities to notify.
         *
         * @var INotifiable[] $notifiables
         */
        foreach ($notifiables as $notifiable) {
            foreach ((array) $original->via($notifiable) as $channel) {
                $notification = clone $original;

                $notification->id = Str::uuid()->toString();

                if (! is_null($this->locale)) {
                    $notification->locale = $this->locale;
                }

                if (!$notifiable->routeNotificationFor($channel, $notification)) {
                    continue;
                }

                $queue = $notification->queue;

                if (method_exists($notification, 'viaQueues')) {
                    $queue = $notification->viaQueues()[$channel] ?? null;
                }

                $this->bus->dispatch(
                    (new DoctrineQueuedNotification($notifiable, $notification, [$channel]))
                        ->onConnection($notification->connection)
                        ->onQueue($queue)
                        ->delay($notification->delay)
                        ->through(
                            array_merge(
                                method_exists($notification, 'middleware') ? $notification->middleware() : [],
                                $notification->middleware ?? []
                            )
                        )
                );
            }
        }
    }
}
