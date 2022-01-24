<?php

namespace App\Core;

use Illuminate\Notifications\Events\NotificationSent as BaseNotificationSent;

class NotificationSent extends BaseNotificationSent
{
    use DoctrineRestoreEntitiesHelper;
}
