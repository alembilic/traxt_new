<?php

namespace App\Http\Transformers;

use App\Entities\Notification;
use League\Fractal\TransformerAbstract;

class NotificationTransformer extends TransformerAbstract
{
    /**
     * Transforms Notification into appropriate api response
     *
     * @param Notification $notification Notification
     *
     * @return array
     */
    public function transform(Notification $notification): array
    {
        return [
            'id' => $notification->getId(),
            'title' => $notification->getTitle(),
            'message' => $notification->getMessage(),
            'status' => $notification->getStatus(),
            'isMail' => $notification->isMail(),
        ];
    }
}
