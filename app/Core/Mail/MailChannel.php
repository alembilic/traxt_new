<?php

namespace App\Core\Mail;

use Illuminate\Contracts\Mail\Mailable;
use Illuminate\Notifications\Channels\MailChannel as BaseMailChannel;
use Illuminate\Notifications\Notification;

class MailChannel extends BaseMailChannel
{
    /**
     * Returns results of work mail channel.
     *
     * {@inheritDoc}
     */
    public function send($notifiable, Notification $notification): ?array
    {
        $message = $notification->toMail($notifiable);

        if (
            ! $notifiable->routeNotificationFor('mail', $notification) &&
            ! $message instanceof Mailable
        ) {
            return null;
        }

        if ($message instanceof Mailable) {
            $message->send($this->mailer);

            return null;
        }

        return $this->mailer->mailer($message->mailer ?? null)->send(
            $this->buildView($message),
            array_merge($message->data(), $this->additionalMessageData($notification)),
            $this->messageBuilder($notifiable, $notification, $message)
        );
    }
}
