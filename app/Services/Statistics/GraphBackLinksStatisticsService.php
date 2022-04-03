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
use App\Enums\StatisticsGroupByValues;
use App\Enums\StatisticsTypes;
use App\Exceptions\DtoException;
use Carbon\Carbon;
use http\Exception\InvalidArgumentException;
use Illuminate\Contracts\Container\BindingResolutionException;

class GraphBackLinksStatisticsService implements IStatisticsService
{
    use EntityManagerFresher;

    /**
     * {@inheritDoc}
     */
    public function getStatistics(StatisticsFilterDto $filterDto): IStatisticsObject
    {
        $items = $this->getGroupByPeriodStatistics($filterDto);

        return new BackLinksStatisticsData([
            BaseStatisticsData::TYPE => StatisticsTypes::BACKLINKS_GRAPH,
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
        $titles = ['Total links', 'Total lost links', 'Total live links'];
        switch ($filterDto->groupBy) {
            case StatisticsGroupByValues::DAYS:
                $field = 'DATEFORMAT(bl.' . BackLink::UPDATED_AT . ", '%Y.%m.%d') as key";
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
            default:
                throw new InvalidArgumentException('Invalid statistics grouping');
        }

        $baseQuery = $this->getEntityManager()->getRepository(BackLink::class)->createQueryBuilder('bl');

        $baseCriteria = [];

        if ($filterDto->periodStart) {
            $baseCriteria[] = $baseQuery->expr()->gte('bl.' . BackLink::UPDATED_AT, $baseQuery->expr()->literal($filterDto->periodStart));
        }

        if ($filterDto->periodEnd) {
            $baseCriteria[] = $baseQuery->expr()->lte('bl.' . BackLink::UPDATED_AT, $baseQuery->expr()->literal($filterDto->periodEnd));
        }

        if ($filterDto->user) {
            $baseCriteria[] = $baseQuery->expr()->eq('bl.' . BackLink::CREATED_BY, $filterDto->user->getId());
        }

        $baseQuery->groupBy('key');
        $items = collect();

        foreach ($titles as $key => $title) {
            $query = clone $baseQuery;
            $criteria = $baseCriteria;
            switch ($key) {
                case 1:
                    $criteria[] = $query->expr()->eq('bl.' . BackLink::LOST, true);
                    break;
                case 2:
                    $criteria[] = $query->expr()->eq('bl.' . BackLink::LOST, false);
                    break;
            }
            $rawItems = $query
                ->select([
                    'count(bl.' . BackLink::ID . ') as value',
                    $field,
                ])
                ->where($baseQuery->expr()->andX(...$criteria))
                ->getQuery();

            foreach ($rawItems->getArrayResult() as $item) {
                $items->put($item['key'] . '-' . $key, new BaseStatisticsItem([
                    BaseStatisticsItem::KEY => $item['key'] . '-' . $key,
                    BaseStatisticsItem::TITLE => $title,
                    BaseStatisticsItem::COUNT => $item['value'],
                    BaseStatisticsItem::DATE => Carbon::parse($item['key']),
                ]));
            }
        }

        return $items->all();
    }
}
