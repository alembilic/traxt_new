<?php

namespace App\Http\Controllers;

use App\Entities\Domain;
use App\Enums\PolicyActions;
use App\Exceptions\BusinessLogicException;
use App\Http\Requests\SaveDomainRequest;
use App\Http\Transformers\RawBackLinkTransformer;
use App\Jobs\ParseBacklinksJob;
use App\Services\UrlParsers\DataForSeoService;
use Doctrine\Common\Collections\Criteria;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

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

    /**
     * Returns list of all domains.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $domains = $this->getRepository(Domain::class)->findBy([
            Domain::USER => $this->user,
        ]);
        return $this->collection($domains);
    }

    /**
     * Returns supplier detail information.
     *
     * @param Domain $domain Domain
     *
     * @return JsonResponse
     *
     * @throws AuthorizationException
     */
    public function show(Domain $domain): JsonResponse
    {
        $this->authorize(PolicyActions::SHOW, $domain);

        return $this->item($domain);
    }

    /**
     * Creates new domain.
     *
     * @param SaveDomainRequest $request Request with domain data
     *
     * @return JsonResponse
     *
     * @throws BusinessLogicException
     */
    public function store(SaveDomainRequest $request): JsonResponse
    {
        $subscription = $this->user->getSubscription();
        $domainsCount = $this->getRepository(Domain::class)->matching(
            Criteria::create()
                ->where(Criteria::expr()->eq(Domain::USER, $this->user))
                ->andWhere(Criteria::expr()->eq(Domain::DELETED, false))
        )->count();
        if ($subscription && ($domainsCount >= $subscription->getProduct()->getDomains())) {
            throw new BusinessLogicException('Domains limit reached for your plan.');
        }

        preg_match(
            '!(?:[a-z0-9](?:[a-z0-9-]{0,61}[a-z0-9])?\.)+[a-z0-9][a-z0-9-]{0,61}[a-z0-9]!',
            $request->domain,
            $result
        );
        $domainName = $result[0];
        $domainUrl = preg_match('!^http!i', $request->domain)
            ? $request->domain
            : 'https://' . $domainName . '/';

        $domain = new Domain($domainName, $this->user);
        $domain->setDomainUrl($domainUrl);

        $this->entityManager->persist($domain);
        $this->entityManager->flush();

        return $this->item($domain)->setStatusCode(JsonResponse::HTTP_CREATED);
    }

    /**
     * Update domain.
     *
     * @param Domain $domain Domain
     * @param SaveDomainRequest $request Request with domain data
     *
     * @return Response
     */
    public function update(Domain $domain, SaveDomainRequest $request): Response
    {
        preg_match(
            '!(?:[a-z0-9](?:[a-z0-9-]{0,61}[a-z0-9])?\.)+[a-z0-9][a-z0-9-]{0,61}[a-z0-9]!',
            $request->domain,
            $result
        );
        $domainName = $result[0];
        $domain->setDomainName($domainName);

        $this->entityManager->persist($domain);
        $this->entityManager->flush();

        return response()->noContent();
    }

    /**
     * Remove Domain.
     *
     * @param Domain $domain Domain
     *
     * @return Response
     *
     * @throws AuthorizationException
     */
    public function destroy(Domain $domain): Response
    {
        $this->authorize(PolicyActions::DESTROY, $domain);

        $this->entityManager->remove($domain);
        $this->entityManager->flush();

        return response()->noContent();
    }
}
