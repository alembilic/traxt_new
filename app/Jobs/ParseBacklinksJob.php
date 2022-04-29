<?php

namespace App\Jobs;

use App\Core\EntityManagerFresher;
use App\Dto\BackLinks\BackLinksRawData;
use App\Entities\BackLink;
use App\Entities\BackLinkLog;
use App\Entities\Domain;
use App\Entities\User;
use App\Services\UrlParsers\DataForSeoService;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\InvalidArgumentException;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Queue\ShouldBeUniqueUntilProcessing;
use Illuminate\Queue\InteractsWithQueue;

class ParseBacklinksJob extends BaseJob implements ShouldBeUniqueUntilProcessing
{
    use EntityManagerFresher;
    use InteractsWithQueue;

    /**
     * Queue to handle this job.
     *
     * @var string
     */
    public $queue = 'default';

    private int $domainId;
    private int $userId;
    private array $linksFilter;

    /**
     * CheckOrderJob constructor.
     *
     * @param Domain $domain
     * @param array $linksFilter
     * @param User $user
     */
    public function __construct(Domain $domain, array $linksFilter, User $user)
    {
        $this->domainId = $domain->getId();
        $this->linksFilter = $linksFilter;
        $this->userId = $user->getId();
    }

    /**
     * Executes the job.
     *
     * @param DataForSeoService $service Url Parser Service
     *
     * @throws BindingResolutionException
     * @throws GuzzleException
     */
    public function handle(DataForSeoService $service): void
    {
        $entityManager = $this->getEntityManager();
        $user = $entityManager->find(User::class, $this->userId);
        /* @var Domain $domain */
        $domain = $entityManager->getRepository(Domain::class)->find($this->domainId);
        if (!$domain || ($user && !$user->isActivePlan()) || $domain->isDeleted()) {
            throw new InvalidArgumentException('Domain expired');
        }

        $map = collect($domain->getBackLinks())->keyBy(function (BackLink $backLink) {
            return $backLink->getSearchKey();
        });
        $backLinks = $service->getBackLinksByPath($domain->getDomainName());

        /* @var BackLinksRawData $backLinkData */
        foreach ($backLinks as $backLinkData) {
            if (
                !in_array($backLinkData->destUrl . $backLinkData->sourceUrl, $this->linksFilter) &&
                !in_array($backLinkData->destUrl, $this->linksFilter)
            ) {
                continue;
            }

            /* @var BackLink $backLink */
            $backLink = $map->get($backLinkData->getSearchKey());
            if (!$backLink) {
                $backLink = new BackLink($backLinkData->sourceUrl, $backLinkData->destUrl, $domain, $user);
                $backLink->fill($backLinkData);
                $entityManager->persist($backLink);
                $entityManager->flush();
            }

            $backLinkLog = new BackLinkLog($backLink, json_encode($backLinkData->toArray()));
            $backLinkLog->fill($backLinkData);
            $entityManager->persist($backLinkLog);
        }

        $entityManager->flush();
    }
}
