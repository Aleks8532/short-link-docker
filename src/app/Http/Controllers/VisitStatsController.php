<?php

namespace App\Http\Controllers;

use App\Link;
use App\VisitStat;
use Carbon\Carbon;
use Illuminate\Http\Request;

class VisitStatsController extends Controller
{
    const DEFAULT_STATS_PERIOD = '14';

    public function allStat(Request $request)
    {

        $statData = VisitStat::join('links', 'link_id', 'id')
            ->selectRaw('links.id, links.link_full, links.link_alias, count(distinct visit_stats.client_id) as count_clients')
            ->where('visit_stats.created_at', '>=', "'".Carbon::now()
                ->subDays(self::DEFAULT_STATS_PERIOD)->startOfDay()."'")
            ->groupBy('links.id', 'links.link_full', 'links.link_alias')
            ->get();

        return view('links.dashboard_stats', ['stats' => $statData]);
    }

    public function oneStat(Request $request)
    {
        $alias = $request->route('path');
        $linkData = Link::where('link_alias', $alias)->first();
        $statData = VisitStat::where('link_id', $linkData->id)->get();

        return view('links.link_stats', ['stats' => $statData, 'link' => $linkData]);
    }
}
