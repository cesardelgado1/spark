<?php

namespace App\Http\Controllers;

use App\Models\Indicator;
use App\Models\StrategicPlan;
use Illuminate\Http\Request;

class HomeController extends Controller
{

    public function index()
    {
        $latestPlan = StrategicPlan::where('sp_institution', 'UPRM')
            ->orderByRaw("CAST(SUBSTRING_INDEX(sp_years, '-', 1) AS UNSIGNED) DESC")
            ->first();

        if (!$latestPlan) {
            return view('home', [
                'total' => 0,
                'conValor' => 0,
                'sinValor' => 0,
                'porcentaje' => 0,
                'planYears' => 'N/A',
            ]);
        }

        $total = Indicator::whereHas('objective.goal.topic.strategicplan', function ($query) use ($latestPlan) {
            $query->where('sp_id', $latestPlan->sp_id);
        })->count();

        $conValor = Indicator::whereHas('objective.goal.topic.strategicplan', function ($query) use ($latestPlan) {
            $query->where('sp_id', $latestPlan->sp_id);
        })->whereNotNull('i_value')->count();

        $sinValor = $total - $conValor;
        $porcentaje = $total > 0 ? round(($conValor / $total) * 100, 1) : 0;

        $userAgent = request()->header('User-Agent');
        $isMobile = preg_match('/mobile/i', $userAgent);

        $viewName = $isMobile ? 'mobile-home' : 'home';

        return view($viewName, compact('total', 'conValor', 'sinValor', 'porcentaje', 'latestPlan'));
    }

}
