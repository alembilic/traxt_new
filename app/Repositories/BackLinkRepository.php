<?php

namespace App\Repositories;

use App\Dto\BackLinks\BackLinksFilter;
use App\Entities\BackLink;
use App\Entities\Domain;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\ORM\QueryBuilder;
use Illuminate\Support\Collection;

class BackLinkRepository extends EntityRepository
{
    /**
     * Fill query builder for given filters data.
     *
     * @param BackLinksFilter $filter Filters to fill query builder
     *
     * @return Collection<BackLink>
     */
    public function getSources(BackLinksFilter $filter): Collection
    {
        $em = $this->getEntityManager();
        $items = $this->buildQuery($filter)
            ->setFirstResult($filter->getCursor())
            ->setMaxResults($filter->getLimit())
            ->getQuery()
            ->getResult() ?? [];

        return collect($items)->map(function ($item) use ($em) {
            $em->refresh($item);
            return $item;
        });
    }

    /**
     * Count items for given filters data.
     *
     * @param BackLinksFilter $filter Filters to fill query builder
     *
     * @return integer
     */
    public function countLinksByFilter(BackLinksFilter $filter): int
    {
        return count($this->buildQuery($filter)
            ->select('bl.' . BackLink::DEST_URL)
            ->getQuery()
            ->getScalarResult());
    }

    /**
     * Build a query.
     *
     * @param BackLinksFilter $filter Filter
     *
     * @return QueryBuilder
     */
    private function buildQuery(BackLinksFilter $filter): QueryBuilder
    {
        $query = $this->createQueryBuilder('bl');

        $query->innerJoin(
            Domain::class,
            'd',
            Join::WITH,
            $query->expr()->eq('d.' . Domain::ID, 'bl.' . BackLink::DOMAIN)
        );

        $criteria = [$query->expr()->eq('d.' . DOMAIN::DELETED, 0)];
        $parameters = [];

        if ($filter->user) {
            $criteria[] = $query->expr()->eq('bl.' . BackLink::CREATED_BY, $filter->user->getId());
        }
        if ($filter->domain) {
            $criteria[] = $query->expr()->eq('bl.' . BackLink::DOMAIN, $filter->domain);
        }
        if (isset($filter->isLost)) {
            $criteria[] = $query->expr()->eq('bl.' . BackLink::LOST, (int)$filter->isLost);
        }
        if (isset($filter->isLive)) {
            $criteria[] = $query->expr()->eq('bl.' . BackLink::LOST, (int)!$filter->isLost);
        }
        if (isset($filter->isFailed)) {
            $criteria[] = $filter->isFailed
                ? $query->expr()->isNull('bl.' . BackLink::FIRST_SEEN)
                : $query->expr()->isNotNull('bl.' . BackLink::FIRST_SEEN);
        }
        if (isset($filter->indexed)) {
            $criteria[] = $query->expr()->eq('bl.' . BackLink::STATUS_CODE, 200);
        }
        if (isset($filter->follow)) {
            $criteria[] = $query->expr()->eq('bl.' . BackLink::NO_FOLLOW, (int)!$filter->follow);
        }
        if (isset($filter->noindex)) {
            $criteria[] = $query->expr()->eq('bl.' . BackLink::NO_INDEX, (int)$filter->noindex);
        }
        if (isset($filter->rankFrom)) {
            $criteria[] = $query->expr()->gte('bl.' . BackLink::RANK, $filter->rankFrom);
        }
        if (isset($filter->rankTo)) {
            $criteria[] = $query->expr()->lte('bl.' . BackLink::RANK, $filter->rankTo);
        }
        if ($filter->search) {
            $criteria[] = $query->expr()->orX(
                $query->expr()->like('bl.' . BackLink::SOURCE_URL, $query->expr()->literal($filter->search)),
                $query->expr()->like('bl.' . BackLink::DEST_URL, $query->expr()->literal($filter->search)),
            );
        }
        if (isset($filter->dateFrom)) {
            $criteria[] = $query->expr()->lte(
                'bl.' . BackLink::LAST_SEEN,
                $query->expr()->literal($filter->dateFrom->startOfDay()->format('Y-m-d H:i:s'))
            );
        }
        if (isset($filter->dateTo)) {
            $criteria[] = $query->expr()->gte(
                'bl.' . BackLink::LAST_SEEN,
                $query->expr()->literal($filter->dateTo->endOfDay()->format('Y-m-d H:i:s'))
            );
        }

        return $query->where($query->expr()->andX(...$criteria))
            ->setParameters($parameters)
            ->groupBy('bl.' . BackLink::DEST_URL);
    }
}
