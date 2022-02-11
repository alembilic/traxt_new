<?php

namespace App\Http\Controllers;

use App\Entities\Domain;
use App\Http\Transformers\RawBackLinkTransformer;
use App\Jobs\ParseBacklinksJob;
use App\Services\UrlParsers\DataForSeoService;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class DomainApiController extends BaseApiController
{
    public function importBackLinks(Domain $domain): Response
    {
        dispatch(new ParseBacklinksJob($domain));

        return response()->noContent();
    }

    /**
     * Returns a list of back links to domain.
     *
     * @param Domain $domain Domain Entity
     * @param DataForSeoService $service DFS service
     * @param RawBackLinkTransformer $transformer Transformer
     *
     * @return JsonResponse
     *
     * @throws GuzzleException
     */
    public function retrieveBackLinks(
        Domain $domain,
        DataForSeoService $service,
        RawBackLinkTransformer $transformer
    ): JsonResponse {
        $backLinks = $service->getBackLinksByPath($domain->getDomainName());

        return $this->collection($backLinks, $transformer);
    }
}
