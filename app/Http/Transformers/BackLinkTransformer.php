<?php

namespace App\Http\Transformers;

use App\Entities\BackLink;
use Illuminate\Contracts\Container\BindingResolutionException;
use League\Fractal\TransformerAbstract;

/**
 * BackLink Transformer
 */
class BackLinkTransformer extends TransformerAbstract
{
    /**
     * Transforms Back Link Data into appropriate api response.
     *
     * @param BackLink $backLink DTO
     *
     * @return array
     *
     * @throws BindingResolutionException
     */
    public function transform(BackLink $backLink): array
    {
        return [
            'id' => $backLink->getId(),
            'rank' => $backLink->getRank(),
            'spamScore' => $backLink->getSpamScore(),
            'sourceUrl' => $backLink->getSourceUrl(),
            'destUrl' => $backLink->getDestUrl(),
            'firstSeen' => $backLink->getFirstSeen()->format(DATE_W3C),
            'lastSeen' => $backLink->getLastSeen()->format(DATE_W3C),
            'isLost' => $backLink->isLost(),
            'isNoFollow' => $backLink->isNofollow(),
            'statusCode' => $backLink->getStatusCode(),
            'price' => $backLink->getPrice(),
            'sectionPrice' => $backLink->getSectionPrice(),
        ];
    }
}
