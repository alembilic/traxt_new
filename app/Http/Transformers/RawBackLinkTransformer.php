<?php

namespace App\Http\Transformers;

use App\Dto\BackLinks\BackLinksRawData;
use League\Fractal\TransformerAbstract;

/**
 * Raw TrxBackLink Transformer
 */
class RawBackLinkTransformer extends TransformerAbstract
{
    /**
     * Transforms Back Link Raw Data into appropriate api response.
     *
     * @param BackLinksRawData $backLink DTO
     *
     * @return array
     */
    public function transform(BackLinksRawData $backLink): array
    {
        return [
            'doFollow' => !$backLink->headNofollow,
            'rank' => $backLink->rank,
            'sourceUrl' => $backLink->sourceUrl,
            'destUrl' => $backLink->destUrl,
            'activeSince' => $backLink->firstFound,
            'linkLost' => $backLink->lastFound,
            'isLost' => $backLink->isLost,
        ];
    }
}
