<?php

namespace App\Http\Requests;

/**
 * Class SaveBackLinkSectionRequest
 *
 * @property-read array $links links
 */
class SaveBackLinkSectionRequest extends BaseApiRequest
{
    /**
     * {@inheritDoc}
     */
    public function rules(): array
    {
        return [
            'links' => ['array', 'required'],
        ];
    }
}
