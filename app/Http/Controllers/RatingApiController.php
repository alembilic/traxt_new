<?php

namespace App\Http\Controllers;

use App\Entities\Contact;
use App\Entities\Rating;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class RatingApiController extends BaseApiController
{
    public function getRatings(Request $request): JsonResponse
    {
        $contactId = $request->get('contactId');

        //make route for rating api

        // make get reviews for contact and save rating

        $ratings = collect($this->entityManager->getRepository(Rating::class)->findBy([
            Rating::CONTACT => $contactId
        ]));
        return $this->collection($ratings);
    }
}