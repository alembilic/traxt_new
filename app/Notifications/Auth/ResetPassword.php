<?php

namespace App\Notifications\Auth;

use App\Contracts\INotifiable;
use App\Notifications\BaseNotification;
use Illuminate\Notifications\Messages\MailMessage;

/**
 * Reset password notification.
 */
class ResetPassword extends BaseNotification
{
    /**
     * Channel throw which notification should be sent.
     *
     * @var string
     */
    protected string $channel;

    /**
     * Reset password notification.
     *
     * @param string $url
     */
    public function __construct(string $url)
    {
        $this->payload = [
            'url' => $url,
        ];
    }

    /**
     * Sets channel throw which notification should be sent.
     *
     * @param string $channel Channel throw which notification should be sent
     *
     * @return void
     */
    public function setChannel(string $channel): void
    {
        $this->channel = $channel;
    }

    /**
     * {@inheritDoc}
     */
    public function via(INotifiable $notifiable): array
    {
        return [$this->channel];
    }

    /**
     * Generates mail message.
     *
     * @return MailMessage
     */
    public function toMail(): MailMessage
    {
        return (new MailMessage())
            ->view('mails.reset_password', $this->getPayload())
            ->subject('Traxr: Reset password');
    }
}
