<?php

namespace App\Core;

use Illuminate\Notifications\SendQueuedNotifications;

class DoctrineQueuedNotification extends SendQueuedNotifications
{
    use DoctrineRestoreEntitiesHelper;
}
