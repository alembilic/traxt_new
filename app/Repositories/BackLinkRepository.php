<?php

namespace App\Repositories;

use App\Dto\BackLinks\BackLinksFilter;
use App\Dto\BackLinks\BackLinksRawData;
use App\Entities\BackLink;
use App\Entities\Domain;
use Carbon\Carbon;
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
    public function getSections(BackLinksFilter $filter): Collection
    {
        $items = $this->buildQuery($filter)
            ->setFirstResult($filter->getCursor())
            ->setMaxResults($filter->getLimit())
            ->getQuery()
            ->getResult() ?? [];

        return collect($items)->map(function ($item) {
            return new BackLinksRawData([
                BackLinksRawData::DEST_URL => $item[BackLink::DEST_URL],
                BackLinksRawData::SOURCE_URL => $item[BackLink::SOURCE_URL],
                BackLinksRawData::RESPONSE => (int)$item[BackLink::STATUS_CODE],
                BackLinksRawData::SPAM_SCORE => (int)$item[BackLink::SPAM_SCORE],
                BackLinksRawData::RANK => (int)$item[BackLink::RANK],
                BackLinksRawData::ID => (int)$item[BackLink::ID],
                BackLinksRawData::FIRST_FOUND => Carbon::parse($item[BackLink::FIRST_SEEN]),
                BackLinksRawData::LAST_FOUND => Carbon::parse($item[BackLink::LAST_SEEN]),
                BackLinksRawData::REL_NOFOLLOW => $item[BackLink::NO_FOLLOW],
                BackLinksRawData::PRICE => floatval($item[BackLink::PRICE] ?? 0),
                BackLinksRawData::IS_LOST => (bool)$item[BackLink::LOST],
                BackLinksRawData::DOMAIN_NAME => $item[Domain::DOMAIN_NAME],
            ]);
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
        $query->select([
            'd.' . Domain::DOMAIN_NAME,
            'bl.' . BackLink::DEST_URL,
            'bl.' . BackLink::SOURCE_URL,
            'bl.' . BackLink::SPAM_SCORE,
            'bl.' . BackLink::RANK,
            'bl.' . BackLink::FIRST_SEEN,
            'bl.' . BackLink::LAST_SEEN,
            'bl.' . BackLink::NO_FOLLOW,
            'MAX(bl.' . BackLink::ID . ') as ' . BackLink::ID,
            'MAX(bl.' . BackLink::STATUS_CODE . ') as ' . BackLink::STATUS_CODE,
            'SUM(bl.' . BackLink::PRICE . ') as ' . BackLink::PRICE,
            'SUM(IFELSE(bl.' . BackLink::LOST . ' = 1, 1, 0)) as ' . BackLink::LOST,
        ]);

        return $query->where($query->expr()->andX(...$criteria))
            ->setParameters($parameters)
            ->groupBy('bl.' . BackLink::DEST_URL);
    }
}
