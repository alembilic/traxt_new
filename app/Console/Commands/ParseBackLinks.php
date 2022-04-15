<?php

namespace App\Console\Commands;

use App\Core\EntityManagerFresher;
use App\Dto\BackLinks\BackLinksRawData;
use App\Entities\BackLink;
use App\Entities\BackLinkLog;
use App\Entities\Domain;
use App\Entities\User;
use App\Services\UrlParsers\DataForSeoService;
use Doctrine\ORM\Query\Expr;
use Illuminate\Console\Command;
use Illuminate\Contracts\Container\BindingResolutionException;

class ParseBackLinks extends Command
{
    use EntityManagerFresher;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'backlinks:parse';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Runs job to parse backlinks';

    /**
     * Execute the console command.
     *
     * @param DataForSeoService $service Seo Service
     *
     * @return int
     *
     * @throws BindingResolutionException
     */
    public function handle(DataForSeoService $service): int
    {
        $em = $this->getEntityManager();

        $query = $em->getRepository(Domain::class)->createQueryBuilder('d');
        $query->innerJoin(User::class, 'u', Expr\Join::WITH, $query->expr()->andX(
            $query->expr()->eq('u.' . User::ID, 'd.' . Domain::USER),
            $query->expr()->eq('u.' . User::ACTIVE_PLAN, true),
        ));
        $query->where($query->expr()->eq('d.' . Domain::DELETED, false));

        $domains = $query->getQuery()->getResult();

        /* @var Domain $domain */
        foreach ($domains as $domain) {
            $map = collect($domain->getBackLinks())->keyBy(function (BackLink $backLink) {
                return $backLink->getSearchKey();
            });

            /* @var BackLinksRawData $backLinkData */
            /* @var BackLink $backLink */
            $backLinks = $service->getBackLinksByPath($domain->getDomainUrl());
            foreach ($backLinks as $backLinkData) {
                $backLink = $map->get($backLinkData->getSearchKey());
                if (!$backLink) {
                    continue;
                }
                $backLinkLog = new BackLinkLog($backLink, json_encode($backLinkData->toArray()));

                $backLink->fill($backLinkData);
                $em->persist($backLink);
                $em->persist($backLinkLog);
            }

            $em->detach($domain);
            $em->flush();
            unset($map);
        }

        return 0;
    }
}
