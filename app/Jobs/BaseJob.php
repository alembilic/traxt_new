<?php

namespace App\Jobs;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;

/**
 * Base job.
 */
abstract class BaseJob implements ShouldQueue
{
    use Queueable;

    /**
     * Calculate the number of seconds to wait before retrying the job.
     *
     * @return array
     */
    public function backoff(): array
    {
        return [Carbon::SECONDS_PER_MINUTE, Carbon::SECONDS_PER_MINUTE * 10, Carbon::SECONDS_PER_MINUTE * 30];
    }
}
