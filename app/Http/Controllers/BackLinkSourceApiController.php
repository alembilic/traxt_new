<?php

namespace App\Http\Controllers;

use App\Entities\BackLink;
use App\Entities\Domain;
use App\Enums\PolicyActions;
use App\Exceptions\BusinessLogicException;
use App\Http\Requests\SaveDomainRequest;
use Doctrine\Common\Collections\Criteria;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class BackLinkSourceApiController extends BaseApiController
{
    /**
     * Returns list of all BackLink.
     *
     * @param BackLink $backLink BackLink
     *
     * @return JsonResponse
     */
    public function index(BackLink $backLink): JsonResponse
    {
        $links = collect($this->entityManager->getRepository(BackLink::class)->findBy([
            BackLink::DEST_URL => $backLink->getDestUrl(),
            BackLink::CREATED_BY => $this->user->getId(),
        ]));

        return $this->collection($links);
    }

    /**
     * Returns BackLink detail information.
     *
     * @param BackLink $backLink BackLink
     *
     * @return JsonResponse
     *
     * @throws AuthorizationException
     */
    public function show(BackLink $backLink): JsonResponse
    {
        $this->authorize(PolicyActions::SHOW, $backLink);

        return $this->item($backLink);
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
     * Remove BackLink.
     *
     * @param BackLink $backLink BackLink
     *
     * @return Response
     *
     * @throws AuthorizationException
     */
    public function destroy(BackLink $backLink): Response
    {
        $this->authorize(PolicyActions::DESTROY, $backLink);

        $linksToRemove = $this->entityManager->getRepository(BackLink::class)->findBy([
            BackLink::DEST_URL => $backLink->getDestUrl(),
            BackLink::CREATED_BY => $this->user->getId(),
        ]);

        foreach ($linksToRemove as $link) {
            $this->entityManager->remove($link);
        }

        $this->entityManager->flush();

        return response()->noContent();
    }
}
