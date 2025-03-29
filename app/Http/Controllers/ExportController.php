<?php

//namespace App\Http\Controllers;
//
//use Illuminate\Http\Request;
//
//class ExportController extends Controller
//{
//    //
//}

namespace App\Http\Controllers;

use App\Exports\StrategicPlanExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;

class ExportController extends Controller
{
    public function export()
    {
        return Excel::download(new StrategicPlanExport, 'strategic_plans.xlsx');
    }
}
