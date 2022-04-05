<?php

namespace App\Http\Requests;

/**
 * Class SaveAliasRequest
 *
 * @property-read string $domain Alias
 */
class SaveDomainRequest extends BaseApiRequest
{
    /**
     * {@inheritDoc}
     */
    public function rules(): array
    {
        return [
            'domain' => ['string', 'required'],
        ];
    }
}
