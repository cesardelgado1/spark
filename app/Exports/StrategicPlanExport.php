<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Illuminate\Support\Collection;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class StrategicPlanExport implements FromCollection, WithHeadings, WithStyles, WithEvents
{
    protected $sp_id;
    protected $topics;
    protected $goals;
    protected $objectives;

    public function __construct($sp_id, $topics = [], $goals = [], $objectives = [])
    {
        $this->sp_id = $sp_id;
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
            ->select(
                'SP.sp_id', 'SP.sp_institution',
                'T.t_id', 'T.t_num', 'T.t_text',
                'G.g_id', 'G.g_num', 'G.g_text',
                'O.o_id', 'O.o_num', 'O.o_text',
                'I.i_id', 'I.i_num', 'I.i_text', 'I.i_type', 'I.i_doc_path', 'I.i_value'
            );

        if (!empty($this->topics)) {
            $query->whereIn('T.t_id', $this->topics);
        }

        if (!empty($this->goals)) {
            $query->whereIn('G.g_id', $this->goals);
        }

        if (!empty($this->objectives)) {
            $query->whereIn('O.o_id', $this->objectives);
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

    // ...rest of your class remains the same...
    public function headings(): array
    {
        // Define custom headings for the pivot table
        return ['Asuntos', 'Metas', 'Objetivos', 'Indicadores', 'Valor de Indicador'];
    }

    /**
     * Pivot the data by institution and FY - HAY QUE WORK ON THIS LATER!!
     */
    private function pivotData(Collection $data)
    {
        // Group data by institution
        $grouped = $data->groupBy('asuntos');

        // Flatten the grouped data into a new array
        $pivotTable = [];
        foreach ($grouped as $institution => $items) {
            foreach ($items as $item) {
                $pivotTable[] = [
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

    public function styles($sheet)
    {
        // Apply border to all cells
        $sheet->getStyle('A1:E1')->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

        // Align header cells to the center
        $sheet->getStyle('A1:E1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A1:E1')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);  // Vertical center alignment

        // Set background color for the header row
//        $sheet->getStyle('A1:E1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
//        $sheet->getStyle('A1:E1')->getFill()->getStartColor()->setRGB('A9D08E');
        $sheet->getStyle('A1:E1')->getFont()->setBold(true);

        // Align merged cells to the center (both horizontally and vertically)
        $sheet->getStyle('A2:A' . $sheet->getHighestRow())->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
        $sheet->getStyle('A2:A' . $sheet->getHighestRow())->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $sheet->getStyle('B2:B' . $sheet->getHighestRow())->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
        $sheet->getStyle('B2:B' . $sheet->getHighestRow())->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $sheet->getStyle('C2:C' . $sheet->getHighestRow())->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
        $sheet->getStyle('C2:C' . $sheet->getHighestRow())->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        // Auto-fit columns based on the content
        foreach (range('A', 'E') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        return $sheet;
    }


    // Merge cells with the same value in the first three columns
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet;
                $rowCount = $sheet->getHighestRow(); // Get the number of rows

                $startRow = 2; // Skip header row

                // Merge for columns A, B, and C (Asuntos, Metas, Objetivos)
                for ($col = 1; $col <= 3; $col++) {
                    $lastValue = null;
                    $startMergeRow = null;
                    $columnLetter = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($col); // Convert col number to letter

                    // Iterate over the rows and check for duplicate values in the current column
                    for ($row = $startRow; $row <= $rowCount; $row++) {
                        $currentValue = $sheet->getCell($columnLetter . $row)->getValue();

                        if ($currentValue == $lastValue) {
                            // If the value is the same as the previous one, extend the merge range
                            $endMergeRow = $row;
                        } else {
                            // Merge the previous range if there was one
                            if ($startMergeRow !== null && $startMergeRow < $row - 1) {
                                $sheet->mergeCells("{$columnLetter}{$startMergeRow}:{$columnLetter}" . ($row - 1));
                            }

                            // Update for the next value
                            $startMergeRow = $row;
                            $lastValue = $currentValue;
                        }
                    }

                    // Merge the last range (if any)
                    if ($startMergeRow !== null && $startMergeRow < $rowCount) {
                        $sheet->mergeCells("{$columnLetter}{$startMergeRow}:{$columnLetter}{$rowCount}");
                    }
                }

            }
        ];
    }
}
