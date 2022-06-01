<?php

namespace App\Http\Controllers;

use App\Entities\Contact;
use App\Entities\Rating;
use App\Http\Requests\SaveRatingRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RatingApiController extends BaseApiController
{
    public function getRatings(Request $request): JsonResponse
    {
        $contactId = $request->get('contactId');

        $ratings = collect($this->entityManager
            ->getRepository(Rating::class)
            ->findBy([Rating::CONTACT => $contactId], ['createdAt' => 'DESC']));
        return $this->collection($ratings);
    }

    /**
     * Create rating.
     *
     * @param SaveRatingRequest $request Request
     *
     * @return JsonResponse
     */
    public function createOrUpdate(SaveRatingRequest $request): JsonResponse
    {
        $jsonResponse = JsonResponse::HTTP_CREATED;

        $rating = collect($this->entityManager->getRepository(Rating::class)->findBy([
            Rating::CONTACT => $request->contactId,
            Rating::USER => $this->user
        ]))->first();

        if (!$rating) {
            $contact = $this->entityManager->getRepository(Contact::class)->find($request->contactId);
            $rating = new Rating($request->value, $request->comment, $this->user, $contact);
        } else {
            $rating->setRatingValue($request->value);
            $rating->setComment($request->comment);
            $jsonResponse = Response::HTTP_NO_CONTENT;
        }

        $this->entityManager->persist($rating);
        $this->entityManager->flush();

        return $this->item($rating)->setStatusCode($jsonResponse);
    }
}
