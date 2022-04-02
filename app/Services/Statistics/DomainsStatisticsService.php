<?php

namespace App\Services\Statistics;

use App\Contracts\Statistics\IStatisticsObject;
use App\Contracts\Statistics\IStatisticsService;
use App\Core\EntityManagerFresher;
use App\Dto\Statistics\BackLinksStatisticsData;
use App\Dto\Statistics\BaseStatisticsData;
use App\Dto\Statistics\BaseStatisticsItem;
use App\Dto\Statistics\StatisticsFilterDto;
use App\Entities\BackLink;
use App\Enums\StatisticsTypes;
use App\Exceptions\DtoException;
use Illuminate\Contracts\Container\BindingResolutionException;

class DomainsStatisticsService implements IStatisticsService
{
    use EntityManagerFresher;

    /**
     * {@inheritDoc}
     */
    public function getStatistics(StatisticsFilterDto $filterDto): IStatisticsObject
    {
        $items = $this->getGroupByPeriodStatistics($filterDto);

        return new BackLinksStatisticsData([
            BaseStatisticsData::TYPE => StatisticsTypes::DOMAINS,
            BaseStatisticsData::TOTAL_COUNT => collect($items)->count(),
            BaseStatisticsData::ITEMS => $items,
        ]);
    }

    /**
     * Returns order statistics grouped by some period (days/weeks/months/years).
     *
     * @param StatisticsFilterDto $filterDto Filter data
     *
     * @return array
     *
     * @throws BindingResolutionException
     * @throws DtoException
     */
    protected function getGroupByPeriodStatistics(StatisticsFilterDto $filterDto): array
    {
        $field = 'IDENTITY(bl.' . BackLink::DOMAIN . ') as key';

        $query = $this->getEntityManager()->getRepository(BackLink::class)->createQueryBuilder('bl');

        $criteria = [];

        if ($filterDto->periodStart) {
            $criteria[] = $query->expr()->gte('bl.' . BackLink::UPDATED_AT, $query->expr()->literal($filterDto->periodStart));
        }

        if ($filterDto->periodEnd) {
            $criteria[] = $query->expr()->lte('bl.' . BackLink::UPDATED_AT, $query->expr()->literal($filterDto->periodEnd));
        }

        if ($filterDto->user) {
            $criteria[] = $query->expr()->eq('bl.' . BackLink::CREATED_BY, $filterDto->user->getId());
        }

        $rawItems = $query
            ->select([
                'count(bl.' . BackLink::ID . ') as value',
                $field,
            ])
            ->where($query->expr()->andX(...$criteria))
            ->groupBy('key')
            ->getQuery();

        $items = [];
        foreach ($rawItems->getArrayResult() as $item) {
            $items[] = new BaseStatisticsItem([
                BaseStatisticsItem::KEY => $item['key'],
                BaseStatisticsItem::COUNT => $item['value'],
            ]);
        }

        return $items;
    }
}
