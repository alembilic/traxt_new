<?php

namespace App\Notifications;

use App\Contracts\INotifiable;
use App\Enums\Queues;
use Carbon\CarbonInterface;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Notifications\Messages\SimpleMessage;
use Illuminate\Notifications\Notification;

/**
 * Base application notification.
 */
abstract class BaseNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Payload message data.
     *
     * @var array
     */
    protected array $payload;

    /**
     * Returns notification's payload as array.
     *
     * @return array
     */
    public function getPayload(): array
    {
        return $this->payload;
    }

    /**
     * Sets notification's payload.
     *
     * @param array $payload payload
     */
    public function setPayload(array $payload): void
    {
        $this->payload = $payload;
    }

    /**
     * Notification routes.
     *
     * @param INotifiable $notifiable Notifiable
     *
     * @return array
     */
    abstract public function via(INotifiable $notifiable): array;

    /**
     * Determine which queues should be used for each notification channel.
     *
     * @return array
     */
    public function viaQueues(): array
    {
        return [
            'mail' => Queues::NOTIFICATIONS,
        ];
    }

    /**
     * Returns message content by channel.
     *
     * @param string $channel channel
     *
     * @return string
     */
    public function getContentByChannel(string $channel): string
    {
        /**
         * Message.
         *
         * @var Renderable $message
         */
        $message = $this->{'to' . ucfirst($channel)}();
        return $channel === 'mail' ? $message->render() : $message->content;
    }

    /**
     * Returns message subject/title by channel.
     *
     * @param string $channel channel
     *
     * @return string|null
     */
    public function getSubjectByChannel(string $channel): ?string
    {
        /**
         * Message.
         *
         * @var SimpleMessage $message
         */
        $message = $this->{'to' . ucfirst($channel)}();
        return $channel === 'mail' ? $message->subject : null;
    }

    /**
     * Calculate the number of seconds to wait before retrying the job.
     *
     * @return array
     */
    public function backoff(): array
    {
        return [
            CarbonInterface::SECONDS_PER_MINUTE,
            CarbonInterface::SECONDS_PER_MINUTE * 10,
            CarbonInterface::SECONDS_PER_MINUTE * 30,
        ];
    }
}
