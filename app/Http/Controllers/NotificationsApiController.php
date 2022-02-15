<?php

namespace App\Http\Controllers;

use App\Core\EntityManagerFresher;
use App\Entities\Notification;
use Doctrine\Common\Collections\Criteria;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class NotificationsApiController extends BaseApiController
{
    use EntityManagerFresher;

    public function index(Request $request): JsonResponse
    {
        $criteria = Criteria::create();
        $criteria->setMaxResults(100);
        if ($request->get('status')) {
            $criteria->where(Criteria::expr()->eq(Notification::STATUS, 1));
        }

        $this->collection($this->user->getNotifications()->matching($criteria));
    }

    /**
     * Marks all notifications as read.
     *
     * @return Response
     *
     * @throws BindingResolutionException
     */
    public function markAsReadAll(): Response
    {
        $em = $this->getEntityManager();
        $criteria = Criteria::create();
        $criteria->setMaxResults(100);
        $criteria->where(Criteria::expr()->eq(Notification::STATUS, 1));
        $notifications = $this->user->getNotifications()->matching($criteria);

        /* @var Notification $notification*/
        foreach ($notifications as $notification) {
            $notification->setStatus(2);
            $em->persist($notification);
        }
        $em->flush();

        return response()->noContent();
    }

    /**
     * Marks single notifications as read.
     *
     * @param Notification $notification Notification
     *
     * @return Response
     *
     * @throws BindingResolutionException
     */
    public function markAsRead(Notification $notification): Response
    {
        //TODO: change to policy
        if ($this->user->getId() !== $notification->getUser()->getId()) {
            throw new AccessDeniedHttpException();
        }
        $notification->setStatus(2);

        $em = $this->getEntityManager();
        $em->persist($notification);
        $em->flush();

        return response()->noContent();
    }
}
