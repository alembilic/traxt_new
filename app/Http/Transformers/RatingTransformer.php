<?php

namespace App\Http\Transformers;

use App\Entities\Rating;
use League\Fractal\TransformerAbstract;

class RatingTransformer extends TransformerAbstract
{
    /**
     * Transforms Rating into appropriate api response
     *
     * @param Rating $rating Rating
     *
     * @return array
     */
    public function transform(Rating $rating): array
    {
        return [
            'id' => $rating->getId(),
            'value' => $rating->getValue(),
            'comment' => $rating->getComment(),
            'name' => $rating->getUser()->getFullName(),
            'percent' => $rating->getValueAsPercent(),
            'created' => $rating->getCreated()
        ];
    }
}
