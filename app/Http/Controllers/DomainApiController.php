<?php

namespace App\Http\Controllers;

use App\Entities\Domain;
use App\Http\Transformers\RawBackLinkTransformer;
use App\Jobs\ParseBacklinksJob;
use App\Services\UrlParsers\DataForSeoService;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class DomainApiController extends BaseApiController
{
    /**
     * Create backlinks.
     *
     * @param Domain $domain Domain Entity
     * @param Request $request Request
     *
     * @return Response
     */
    public function importBackLinks(Domain $domain, Request $request): Response
    {
        dispatch_sync(new ParseBacklinksJob($domain, $request->get('links', []), $this->user));

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
