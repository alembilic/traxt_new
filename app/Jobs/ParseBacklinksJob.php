<?php

namespace App\Jobs;

use App\Core\EntityManagerFresher;
use App\Dto\BackLinksRawData;
use App\Entities\Domain;
use App\Entities\ExternalLink;
use App\Entities\ImportedUrl;
use App\Entities\Link;
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
    private array $linksFilter = [];

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
        if (!$domain) {
            throw new InvalidArgumentException('Domain expired');
        }

        $backLinks = $service->getBackLinksByPath($domain->getDomainName());

        $i = 0;
        $urls = collect();
        /* @var BackLinksRawData $linkData */
        foreach ($backLinks as $linkData) {
            if (!in_array($linkData->destUrl . $linkData->sourceUrl, $this->linksFilter)) {
                continue;
            }

            /* @var ImportedUrl $iu */
            $iu = $urls->get($linkData->destUrl);
            if (!$iu) {
                $iu = $entityManager->getRepository(ImportedUrl::class)->findOneBy(['url' => $linkData->destUrl]);
                if ($iu) {
                    $urls->put($linkData->destUrl, $iu);
                }
            }
            if (!$iu) {
                $iu = new ImportedUrl($linkData->destUrl);
                $entityManager->persist($iu);
                $link = new Link($iu, $user);
                $entityManager->persist($link);
                $urls->put($linkData->destUrl, $iu);
            }

            $backLink = new ExternalLink($iu, $linkData->sourceUrl);
            $backLink->fill($linkData);
            $backLink->setDomain($domain->getDomainName());
            $entityManager->persist($backLink);
            if ($i % 100 === 0) {
                $entityManager->flush();
            }
            $i++;
        }

        $entityManager->flush();
    }
}
