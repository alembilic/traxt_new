<?php

namespace App\Http\Controllers;

use App\Entities\BackLink;
use App\Entities\Domain;
use App\Enums\PolicyActions;
use App\Exceptions\BusinessLogicException;
use App\Http\Requests\SaveBackLinkSectionRequest;
use App\Jobs\ParseBacklinksJob;
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
     * Creates new backlink.
     *
     * @param SaveBackLinkSectionRequest $request Request with links data
     *
     * @return JsonResponse
     *
     * @throws BusinessLogicException
     */
    public function store(SaveBackLinkSectionRequest $request): JsonResponse
    {
        $subscription = $this->user->getSubscription();
        $linksCount = $this->getRepository(BackLink::class)->matching(
            Criteria::create()
                ->where(Criteria::expr()->eq(BackLink::CREATED_BY, $this->user))
        )->count() + count($request->links);
        if ($subscription && ($linksCount >= $subscription->getProduct()->getLinks())) {
            throw new BusinessLogicException('Backlinks limit reached for your plan.');
        }

        //TODO: move this code to job
        $domains = collect($this->user->getDomains())->keyBy(function (Domain $domain) {
            return $domain->getDomainName();
        });

        foreach ($request->links as $link) {
            $linkData = explode('/', $link);
            $domain = $domains->get($linkData[2] ?? '');
            if (!$domain) {
                preg_match('!(?:[a-z0-9](?:[a-z0-9-]{0,61}[a-z0-9])?\.)+[a-z0-9][a-z0-9-]{0,61}[a-z0-9]!', $link, $result);
                $domainName = $result[0];
                $domainUrl = preg_match('!^http!i', $link) ? $link : 'https://' . $domainName . '/';

                $domain = new Domain($domainName, $this->user);
                $domain->setDomainUrl($domainUrl);

                $this->entityManager->persist($domain);
                $this->entityManager->flush();
                $domains->put($domainName, $domain);
            }

            dispatch_sync(new ParseBacklinksJob($domain, [$link], $this->user));
        }

        return $this->collection([])->setStatusCode(JsonResponse::HTTP_CREATED);
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
