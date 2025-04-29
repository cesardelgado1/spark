<?php

namespace App\Http\Controllers;

use App\Models\Indicator;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Calculate indicators progress
        $total = Indicator::whereHas('objective.goal.topic.strategicplan', function ($query) {
            $query->where('sp_institution', 'UPRM');
        })->count();

        $conValor = Indicator::whereHas('objective.goal.topic.strategicplan', function ($query) {
            $query->where('sp_institution', 'UPRM');
        })->whereNotNull('i_value')->count();

        $sinValor = $total - $conValor;
        $porcentaje = $total > 0 ? round(($conValor / $total) * 100, 1) : 0;

        // Check if user is on mobile device
        $userAgent = request()->header('User-Agent');

        if (preg_match('/mobile/i', $userAgent)) {
            // If mobile, return the mobile version
            return view('mobile-home', compact('total', 'conValor', 'sinValor', 'porcentaje'));
        }

        // Otherwise return normal desktop view
        return view('home', compact('total', 'conValor', 'sinValor', 'porcentaje'));
    }
}
