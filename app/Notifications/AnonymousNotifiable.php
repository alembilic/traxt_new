<?php

namespace App\Notifications;

use App\Contracts\INotifiable;
use App\Entities\Helpers\Notifiable;

/**
 * Represent notifiable object when no any appropriate object.
 */
class AnonymousNotifiable implements INotifiable
{
    use Notifiable;

    /**
     * {@inheritDoc}
     */
    public function getId(): ?int
    {
        return null;
    }
}
