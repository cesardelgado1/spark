<?php

namespace App\Http\Controllers;

use App\Models\Indicator;
use App\Models\StrategicPlan;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Displays the home page (or mobile version) with indicator progress stats.
     *
     * Loads the most recent UPRM strategic plan and calculates:
     * - Total indicators
     * - Indicators with values
     * - Indicators without values
     * - Completion percentage
     */
    public function index()
    {
        // Get latest UPRM strategic plan by starting year (descending)
        $latestPlan = StrategicPlan::where('sp_institution', 'UPRM')
            ->orderByRaw("CAST(SUBSTRING_INDEX(sp_years, '-', 1) AS UNSIGNED) DESC")
            ->first();

        // If no plan found, return default values
        if (!$latestPlan) {
            return view('home', [
                'total' => 0,
                'conValor' => 0,
                'sinValor' => 0,
                'porcentaje' => 0,
                'planYears' => 'N/A',
            ]);
        }

        // Count all indicators under the latest plan
        $total = Indicator::whereHas('objective.goal.topic.strategicplan', function ($query) use ($latestPlan) {
            $query->where('sp_id', $latestPlan->sp_id);
        })->count();

        // Count indicators that have a value
        $conValor = Indicator::whereHas('objective.goal.topic.strategicplan', function ($query) use ($latestPlan) {
            $query->where('sp_id', $latestPlan->sp_id);
        })->whereNotNull('i_value')->count();

        $sinValor = $total - $conValor;
        $porcentaje = $total > 0 ? round(($conValor / $total) * 100, 1) : 0;

        // Detect if user is on a mobile device
        $userAgent = request()->header('User-Agent');
        $isMobile = preg_match('/mobile/i', $userAgent);

        $viewName = $isMobile ? 'mobile-home' : 'home';

        return view($viewName, compact('total', 'conValor', 'sinValor', 'porcentaje', 'latestPlan'));
    }
}
