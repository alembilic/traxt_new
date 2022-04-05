<?php

namespace App\Http\Transformers;

use App\Entities\Domain;
use League\Fractal\TransformerAbstract;

class DomainTransformer extends TransformerAbstract
{
    /**
     * Transforms Domain into appropriate api response
     *
     * @param Domain $domain Domain
     *
     * @return array
     */
    public function transform(Domain $domain): array
    {
        return [
            'id' => $domain->getId(),
            'url' => $domain->getDomainUrl(),
            'name' => $domain->getDomainName(),
        ];
    }
}
