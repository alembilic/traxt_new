<?php

namespace App\Services\Statistics;

use App\Contracts\Statistics\IStatisticsService;
use App\Enums\StatisticsTypes;
use http\Exception\InvalidArgumentException;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Container\Container;

/**
 * Factory for statistic services.
 */
class StatisticsServicesFactory
{
    /**
     * Dependency injection container.
     *
     * @var Container
     */
    protected Container $container;

    /**
     * Mapping types with services which serves this types.
     *
     * @var array
     */
    protected array $servicesMapping = [
        StatisticsTypes::BACKLINKS => BackLinksStatisticsService::class,
        StatisticsTypes::DOMAINS => DomainsStatisticsService::class,
    ];

    /**
     * Factory for statistics services.
     *
     * @param Container $container Dependency injection container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * Returns implementation of statistics service by given type.
     *
     * @param string $type Type to which needs to return confirmation service
     *
     * @return IStatisticsService
     *
     * @throws InvalidArgumentException
     * @throws BindingResolutionException
     */
    public function build(string $type): IStatisticsService
    {
        if (!isset($this->servicesMapping[$type])) {
            throw new InvalidArgumentException();
        }

        return $this->container->make($this->servicesMapping[$type]);
    }
}
