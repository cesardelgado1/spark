<?php
//
//namespace App\Exports;
//
//use Illuminate\Support\Facades\DB;
//use Maatwebsite\Excel\Concerns\FromCollection;
//use Maatwebsite\Excel\Concerns\WithHeadings;
//
//class StrategicPlanExport implements FromCollection, WithHeadings
//{
//    public function collection()
//    {
//        // Datagrip Query
////        Select * FROM strategic_plans as SP, topics as T, goals as G, objectives as O, indicators as I
////        where SP.sp_id = T.sp_id
////            And T.t_id = G.t_id
////            AND G.g_id = O.g_id
////            AND O.o_id = I.o_id
//
//        // Query data and return it as a collection
//        $data = DB::table('strategic_plans as SP')
//            ->join('topics as T', 'SP.sp_id', '=', 'T.sp_id')
//            ->join('goals as G', 'T.t_id', '=', 'G.t_id')
//            ->join('objectives as O', 'G.g_id', '=', 'O.g_id')
//            ->join('indicators as I', 'O.o_id', '=', 'I.o_id')
//            ->select('SP.sp_id', 'SP.sp_institution',
//                'T.t_id', 'T.t_num', 'T.t_text',
//                'G.g_id', 'G.g_num', 'G.g_text',
//                'O.o_id', 'O.o_num', 'O.o_text',
//                'I.i_id', 'I.i_num', 'I.i_text', 'I.i_type', 'I.i_doc_path', 'I.i_value')
//            ->get();
//
//        // Adding the new concatenated columns: Asuntos, Metas, Objetivos, Indicadores
//        foreach ($data as $item) {
//            $item->Asuntos = 'Asunto ' . $item->t_num . ': ' . $item->t_text;
//            $item->Metas = 'Meta ' . $item->g_num . ': ' . $item->g_text;
//            $item->Objetivos = 'Objetivo ' . $item->t_num . '.' . $item->g_num . '.' . $item->o_num . ': ' . $item->o_text;
//            $item->Indicadores = 'Indicador ' . $item->t_num . '.' . $item->g_num . '.' . $item->o_num . '.' . $item->i_num . ': ' . $item->i_text;
//        }
//
//        return $data;
//    }
//
//    public function headings(): array
//    {
//        // Retrieve the keys of the first item to dynamically generate headings
//        $data = $this->collection();
//
//        // If there is data, use the keys of the first row as headings
//        return $data->isNotEmpty() ? array_keys((array) $data->first()) : [];
//    }
//}
//

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Collection;

class StrategicPlanExport implements FromCollection, WithHeadings
{
    public function collection()
    {
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

        // Add the new concatenated columns dynamically
        foreach ($data as $item) {
            $item->asuntos = 'Asunto ' . $item->t_num . ': ' . $item->t_text;
            $item->metas = 'Meta ' . $item->g_num . ': ' . $item->g_text;
            $item->objetivos = 'Objetivo ' . $item->t_num . '.' . $item->g_num . '.' . $item->o_num . ': ' . $item->o_text;
            $item->indicadores = 'Indicador ' . $item->t_num . '.' . $item->g_num . '.' . $item->o_num . '.' . $item->i_num . ': ' . $item->i_text;
        }

        // Group by institution and pivot the data
        $pivotData = $this->pivotData($data);

        return $pivotData;
    }

    public function headings(): array
    {
        // Define custom headings for the pivot table
        return ['Asuntos', 'Metas', 'Objetivos', 'Indicadores', 'Valor de Indicador'];
    }

    /**
     * Pivot the data by institution
     */
    private function pivotData(Collection $data)
    {
        // Group data by institution
//        $grouped = $data->groupBy('sp_institution');
        $grouped = $data->groupBy('asuntos');

        // Flatten the grouped data into a new array
        $pivotTable = [];
        foreach ($grouped as $institution => $items) {
            foreach ($items as $item) {
                $pivotTable[] = [
//                    'sp_institution' => $institution,
                    'Asuntos' => $item->asuntos,
                    'Metas' => $item->metas,
                    'Objetivos' => $item->objetivos,
                    'Indicadores' => $item->indicadores,
                    'Valor de Indicador' => $item->i_value
                ];
            }
        }

        return collect($pivotTable);
    }
}
