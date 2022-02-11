<?php

namespace App\Jobs;

use App\Core\EntityManagerFresher;
use App\Dto\BackLinksRawData;
use App\Entities\BackLink;
use App\Entities\BackLinkLog;
use App\Entities\Domain;
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

    /**
     * CheckOrderJob constructor.
     *
     * @param Domain $domain
     */
    public function __construct(Domain $domain)
    {
        $this->domainId = $domain->getId();
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
        $domain = $entityManager->getRepository(Domain::class)->find($this->domainId);
        if (!$domain) {
            throw new InvalidArgumentException('Domain expired');
        }

        $backLinks = $service->getBackLinksByPath($domain->getDomainName());
        /* @var BackLinksRawData $linkData */
        foreach ($backLinks as $linkData) {
            $backLink = new BackLink($linkData->sourceUrl, $domain);
            $backLink->fill($linkData);
            $backLink->setCreatedBy($domain->getCreatedBy());
            $entityManager->persist($backLink);

            $backLinkLog = new BackLinkLog($domain, $backLink, $linkData->toArray());
            $entityManager->persist($backLinkLog);
        }

        $entityManager->flush();
    }
}
