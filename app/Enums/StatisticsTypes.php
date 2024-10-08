<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * Available types of statistics shown to user.
 */
class StatisticsTypes extends Enum
{
    /**
     * Total backlinks for the period and grouped information about backlinks.
     */
    public const BACKLINKS = 'backlinks';

    /**
     * Information about backlinks as graph.
     */
    public const BACKLINKS_GRAPH = 'backlinks_graph';

    /**
     * Total domains for the period and grouped information about domains.
     */
    public const DOMAINS = 'domains';
}
