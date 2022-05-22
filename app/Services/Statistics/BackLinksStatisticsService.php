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
use App\Entities\User;
use App\Enums\StatisticsGroupByValues;
use App\Enums\StatisticsTypes;
use App\Exceptions\DtoException;
use Illuminate\Contracts\Container\BindingResolutionException;

class BackLinksStatisticsService implements IStatisticsService
{
    use EntityManagerFresher;

    /**
     * {@inheritDoc}
     */
    public function getStatistics(StatisticsFilterDto $filterDto): IStatisticsObject
    {
        $items = $this->getGroupByPeriodStatistics($filterDto);

        return new BackLinksStatisticsData([
            BaseStatisticsData::TYPE => StatisticsTypes::BACKLINKS,
            BaseStatisticsData::TOTAL_COUNT => collect($items)->sum(BaseStatisticsItem::COUNT),
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
        $keys = ['Expired backlinks', 'Live backlinks'];
        switch ($filterDto->groupBy) {
            case StatisticsGroupByValues::DAYS:
                $field = 'DATEFORMAT(bl.' . BackLink::UPDATED_AT . ", '%Y-%m-%d') as key";
                break;
            case StatisticsGroupByValues::WEEKS:
                $field = 'DATEFORMAT(bl.' . BackLink::UPDATED_AT . ", '%x.%v') as key";
                break;
            case StatisticsGroupByValues::MONTHS:
                $field = 'DATEFORMAT(bl.' . BackLink::UPDATED_AT . ", '%Y.%m') as key";
                break;
            case StatisticsGroupByValues::YEARS:
                $field = 'YEAR(bl.' . BackLink::UPDATED_AT . ') as key';
                break;
            case StatisticsGroupByValues::LOST:
                $field = 'IFELSE(bl.' . BackLink::LOST . ' = 0, 0, 1) as key';
                break;
            default:
                $field = 'COUNT(bl.' . BackLink::ID . ') as key';
                break;
        }

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

        $items = collect();
        foreach ($rawItems->getArrayResult() as $item) {
            $items->put($item['key'], new BaseStatisticsItem([
                BaseStatisticsItem::KEY => (string)$item['key'],
                BaseStatisticsItem::TITLE => $keys[$item['key']] ?? '',
                BaseStatisticsItem::COUNT => $item['value'],
            ]));
        }

        // Add empty keys if it is necessary
        foreach ($keys as $key => $name) {
            if (!$items->get($key)) {
                $items->put($key, new BaseStatisticsItem([
                    BaseStatisticsItem::KEY => (string)$key,
                    BaseStatisticsItem::TITLE => $name,
                    BaseStatisticsItem::COUNT => 0,
                ]));
            }
        }

        return $items->all();
    }
}
