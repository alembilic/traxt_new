<?php

namespace App\Services\Statistics;

use App\Contracts\Statistics\IStatisticsPeriod;
use App\Contracts\Statistics\IStatisticsPeriodService;
use App\Dto\Statistics\StatisticsFilterDto;
use App\Dto\Statistics\StatisticsPeriodDto;
use App\Enums\StatisticsTypes;
use App\Exceptions\DtoException;
use Carbon\Carbon;
use Illuminate\Contracts\Container\BindingResolutionException;
use ReflectionException;

class StatisticsPeriodService implements IStatisticsPeriodService
{
    /**
     * Statistics Factory.
     *
     * @var StatisticsServicesFactory
     */
    private $servicesFactory;

    /**
     * StatisticsPeriodService constructor.
     *
     * @param StatisticsServicesFactory $servicesFactory Factory
     */
    public function __construct(StatisticsServicesFactory $servicesFactory)
    {
        $this->servicesFactory = $servicesFactory;
    }

    /**
     * Returns statistic data.
     *
     * @param string $type statistics type
     * @param StatisticsFilterDto $filterDto filter
     *
     * @return IStatisticsPeriod
     *
     * @throws DtoException
     * @throws InvalidArgumentException
     * @throws BindingResolutionException
     * @throws ReflectionException
     */
    public function getPeriodStatistics(string $type, StatisticsFilterDto $filterDto): IStatisticsPeriod
    {
        $period = $filterDto->periodStart->diffInDays($filterDto->periodEnd) + 1;

        $previousPeriodFilterDto = clone $filterDto;
        $previousPeriodFilterDto->periodStart = Carbon::parse($filterDto->periodStart)->addDays(-$period);
        $previousPeriodFilterDto->periodEnd = Carbon::parse($filterDto->periodEnd)->addDays(-$period);

        return new StatisticsPeriodDto(
            new StatisticsTypes($type),
            $this->servicesFactory->build($type),
            $filterDto,
            $previousPeriodFilterDto
        );
    }
}
