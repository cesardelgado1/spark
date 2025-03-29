<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class StrategicPlanExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        // Datagrip Query
//        Select * FROM strategic_plans as SP, topics as T, goals as G, objectives as O, indicators as I
//        where SP.sp_id = T.sp_id
//            And T.t_id = G.t_id
//            AND G.g_id = O.g_id
//            AND O.o_id = I.o_id
        
        // Query data and return it as a collection
        $data = DB::table('strategic_plans as SP')
            ->join('topics as T', 'SP.sp_id', '=', 'T.sp_id')
            ->join('goals as G', 'T.t_id', '=', 'G.t_id')
            ->join('objectives as O', 'G.g_id', '=', 'O.g_id')
            ->join('indicators as I', 'O.o_id', '=', 'I.o_id')
            ->select('SP.sp_id', 'SP.sp_institution',
                'T.t_id', 'T.t_num', 'T.t_text',
                'G.g_id', 'G.g_num', 'G.g_text',
                'O.o_id', 'O.o_num', 'O.o_text',
                'I.i_id', 'I.i_num', 'I.i_text', 'I.i_type', 'I.i_doc_path', 'I.i_value')
            ->get();

        return $data;
    }

    public function headings(): array
    {
        // Retrieve the keys of the first item to dynamically generate headings
        $data = $this->collection();

        // If there is data, use the keys of the first row as headings
        return $data->isNotEmpty() ? array_keys((array) $data->first()) : [];
    }
}
