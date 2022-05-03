<?php

namespace App\Http\Controllers;

use App\Entities\Contact;
use App\Entities\Rating;
use App\Http\Requests\SaveRatingRequest;
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

        $ratings = collect($this->entityManager->getRepository(Rating::class)->findBy([
            Rating::CONTACT => $contactId
        ]));
        return $this->collection($ratings);
    }

    /**
     * Create rating.
     *
     * @param Rating $rating Rating
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

        if(!$rating){
            $contact = $this->entityManager->getRepository(Contact::class)->find($request->contactId);
            $rating = new Rating($request->value, $request->comment, $this->user, $contact);
        }
        else{
            $rating->setRatingValue($request->value); 
            $rating->setComment($request->comment); 
            $jsonResponse = JsonResponse::HTTP_NO_CONTENT;
        }
        $this->entityManager->persist($rating);
        $this->entityManager->flush();

        return $this->item($rating)->setStatusCode($jsonResponse);
    }

}