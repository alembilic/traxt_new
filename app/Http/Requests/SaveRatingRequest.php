<?php

namespace App\Http\Requests;

/**
 * Class SaveRatingRequest
 *
 * @property-read string $rating rating
 */
class SaveRatingRequest extends BaseApiRequest
{
    /**
     * {@inheritDoc}
     */
    public function rules(): array
    {
        return [
            'value' => ['integer', 'required'],
            'comment' => ['string'],
            'contactId' => ['integer', 'required'],
        ];
    }
}
