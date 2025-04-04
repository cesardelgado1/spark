<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Illuminate\Support\Collection;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class StrategicPlanExport implements FromCollection, WithHeadings, WithStyles, WithEvents
{
    protected $sp_id;
    protected $fy; // ✅ Nueva propiedad
    protected $topics;
    protected $goals;
    protected $objectives;

    public function __construct($sp_id, $fy, $topics = [], $goals = [], $objectives = [])
    {
        $this->sp_id = $sp_id;
        $this->fy = $fy;
        $this->topics = $topics;
        $this->goals = $goals;
        $this->objectives = $objectives;
    }

    public function collection()
    {
        $query = DB::table('strategic_plans as SP')
            ->join('topics as T', 'SP.sp_id', '=', 'T.sp_id')
            ->join('goals as G', 'T.t_id', '=', 'G.t_id')
            ->join('objectives as O', 'G.g_id', '=', 'O.g_id')
            ->join('indicators as I', 'O.o_id', '=', 'I.o_id')
            ->where('SP.sp_id', $this->sp_id)
            ->where('I.i_FY', $this->fy)
            ->select(
                'SP.sp_id', 'SP.sp_institution',
                'T.t_id', 'T.t_num', 'T.t_text',
                'G.g_id', 'G.g_num', 'G.g_text',
                'O.o_id', 'O.o_num', 'O.o_text',
                'I.i_id', 'I.i_num', 'I.i_text', 'I.i_type', 'I.i_doc_path', 'I.i_value', 'I.i_FY'
            );

        if (!empty($this->objectives)) {
            $query->whereIn('O.o_id', $this->objectives);
        } elseif (!empty($this->goals)) {
            $query->whereIn('G.g_id', $this->goals);
        } elseif (!empty($this->topics)) {
            $query->whereIn('T.t_id', $this->topics);
        }

        $data = $query->get();

        foreach ($data as $item) {
            $item->asuntos = 'Asunto ' . $item->t_num . ': ' . $item->t_text;
            $item->metas = 'Meta ' . $item->g_num . ': ' . $item->g_text;
            $item->objetivos = 'Objetivo ' . $item->t_num . '.' . $item->g_num . '.' . $item->o_num . ': ' . $item->o_text;
            $item->indicadores = 'Indicador ' . $item->t_num . '.' . $item->g_num . '.' . $item->o_num . '.' . $item->i_num . ': ' . $item->i_text;
        }

        return $this->pivotData($data);
    }


    public function headings(): array
    {
        return ['Asuntos', 'Metas', 'Objetivos', 'Indicadores', 'Valor de Indicador', 'FY'];
    }

    private function pivotData(Collection $data)
    {
        $grouped = $data->groupBy('asuntos');

        $pivotTable = [];
        foreach ($grouped as $institution => $items) {
            foreach ($items as $item) {
                $pivotTable[] = [
                    'Asuntos' => $item->asuntos,
                    'Metas' => $item->metas,
                    'Objetivos' => $item->objetivos,
                    'Indicadores' => $item->indicadores,
                    'Valor de Indicador' => $item->i_value,
                    'FY' => $item->i_FY
                ];
            }
        }

        return collect($pivotTable);
    }

    public function styles($sheet)
    {
        $sheet->getStyle('A1:E1')->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
        $sheet->getStyle('A1:E1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A1:E1')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        $sheet->getStyle('A1:E1')->getFont()->setBold(true);

        $sheet->getStyle('A2:A' . $sheet->getHighestRow())->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
        $sheet->getStyle('A2:A' . $sheet->getHighestRow())->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        $sheet->getStyle('B2:B' . $sheet->getHighestRow())->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
        $sheet->getStyle('B2:B' . $sheet->getHighestRow())->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        $sheet->getStyle('C2:C' . $sheet->getHighestRow())->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
        $sheet->getStyle('C2:C' . $sheet->getHighestRow())->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        foreach (range('A', 'E') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        return $sheet;
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet;
                $rowCount = $sheet->getHighestRow();
                $startRow = 2;

                for ($col = 1; $col <= 3; $col++) {
                    $lastValue = null;
                    $startMergeRow = null;
                    $columnLetter = Coordinate::stringFromColumnIndex($col);

                    for ($row = $startRow; $row <= $rowCount; $row++) {
                        $currentValue = $sheet->getCell($columnLetter . $row)->getValue();

                        if ($currentValue == $lastValue) {
                            $endMergeRow = $row;
                        } else {
                            if ($startMergeRow !== null && $startMergeRow < $row - 1) {
                                $sheet->mergeCells("{$columnLetter}{$startMergeRow}:{$columnLetter}" . ($row - 1));
                            }

                            $startMergeRow = $row;
                            $lastValue = $currentValue;
                        }
                    }

                    if ($startMergeRow !== null && $startMergeRow < $rowCount) {
                        $sheet->mergeCells("{$columnLetter}{$startMergeRow}:{$columnLetter}{$rowCount}");
                    }
                }
            }
        ];
    }
}

