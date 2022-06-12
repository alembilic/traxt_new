<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseApiController;
use App\Models\BacklinkLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GraphDataController extends BaseApiController
{
    public function pageRank($type)
    {
        $days = $this->getDays($type);
        $user_id = $this->user()->getId();

        return BacklinkLog::select(
            DB::raw("DATE_FORMAT(created_at,'%Y-%m-%d') as x"),
            DB::raw('SUM(`rank`) as y')
        )
            ->orderBy('x', 'desc')
            ->groupBy('x')
            ->when($days, function ($q) use ($days) {
                $q->take($days);
            })
            ->get();
    }

    public function backlinkSpending($type)
    {
        $days = $this->getDays($type);
        $user_id = $this->user()->getId();

        return BacklinkLog::select(
            DB::raw("DATE_FORMAT(created_at,'%Y-%m-%d') as x"),
            DB::raw('SUM(price) as total'),
            DB::raw('SUM(CASE WHEN is_lost = 1 THEN price ELSE 0 END) as lost'),
            DB::raw('SUM(CASE WHEN is_lost = 0 THEN price ELSE 0 END) as active'),
        )->whereHas('backlink', function ($q) use ($user_id) {
            $q->where('created_by', '=', $user_id);
        })->orderBy('x', 'desc')
            ->groupBy('x')
            ->when($days, function ($q) use ($days) {
                $q->take($days);
            })
            ->get();
    }

    public function backlinkAmount($type)
    {
        $days = $this->getDays($type);
        $user_id = $this->user()->getId();

        return BacklinkLog::select(
            DB::raw("DATE_FORMAT(created_at,'%Y-%m-%d') as x"),
            DB::raw('COUNT(price) as total'),
            DB::raw('COUNT(CASE WHEN is_lost = 1 THEN 1 ELSE NULL END) as lost'),
            DB::raw('COUNT(CASE WHEN is_lost = 0 THEN 1 ELSE NULL END) as active'),
        )->whereHas('backlink', function ($q) use ($user_id) {
            $q->where('created_by', '=', $user_id);
        })->orderBy('x', 'desc')
            ->groupBy('x')
            ->when($days, function ($q) use ($days) {
                $q->take($days);
            })
            ->get();
    }

    public function getDays($type)
    {
        if (!in_array($type, ['week', 'month', 'year', 'all'])) return abort(422);
        $days = null;
        if ($type === 'week') $days = 7;
        elseif ($type === 'month') $days = 30;
        elseif ($type === 'year') $days = 375;

        return $days;
    }
}
