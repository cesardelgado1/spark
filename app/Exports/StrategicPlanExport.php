<?php
//
//namespace App\Exports;
//
//use Illuminate\Support\Facades\DB;
//use Maatwebsite\Excel\Concerns\FromCollection;
//use Maatwebsite\Excel\Concerns\WithHeadings;
//use Maatwebsite\Excel\Concerns\WithStyles;
//use Maatwebsite\Excel\Concerns\WithEvents;
//use Maatwebsite\Excel\Events\AfterSheet;
//use Illuminate\Support\Collection;
//use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
//use PhpOffice\PhpSpreadsheet\Style\Border;
//use PhpOffice\PhpSpreadsheet\Style\Alignment;
//use Maatwebsite\Excel\Concerns\WithTitle;
//
//
///**
// * Class StrategicPlanExport
// *
// * This class handles the generation of an Excel export for indicators within a strategic plan.
// * It supports optional filtering by department, topic, goal, and objective. The output format
// * includes structured data (Asuntos, Metas, Objetivos, Indicadores) and indicator values.
// */
//class StrategicPlanExport implements FromCollection, WithHeadings, WithStyles, WithEvents, WithTitle
//{
//    protected $sp_id;
//    protected $fy;
//    protected $department;
//    protected $topics;
//    protected $goals;
//    protected $objectives;
//
//    /**
//     * StrategicPlanExport constructor.
//     *
//     * @param int $sp_id Strategic Plan ID
//     * @param string $fy Fiscal Year
//     * @param string $department Department name (or "Todos")
//     * @param array $topics Optional topic IDs to filter
//     * @param array $goals Optional goal IDs to filter
//     * @param array $objectives Optional objective IDs to filter
//     */
//    public function __construct($sp_id, $fy, $department, $topics = [], $goals = [], $objectives = [])
//    {
//        $this->sp_id = $sp_id;
//        $this->fy = $fy;
//        $this->department = $department;
//        $this->topics = $topics;
//        $this->goals = $goals;
//        $this->objectives = $objectives;
//    }
//
//    /**
//     * Returns the collection of rows to be exported.
//     *
//     * @return \Illuminate\Support\Collection
//     */
//    public function collection()
//    {
//        if ($this->department === "Todos") {
//            // If department is "Todos", do NOT join with indicator_values or role_requests
//            $query = DB::table('strategic_plans as SP')
//                ->join('topics as T', 'SP.sp_id', '=', 'T.sp_id')
//                ->join('goals as G', 'T.t_id', '=', 'G.t_id')
//                ->join('objectives as O', 'G.g_id', '=', 'O.g_id')
//                ->join('indicators as I', 'O.o_id', '=', 'I.o_id')
//                ->where('SP.sp_id', $this->sp_id)
//                ->where('I.i_FY', $this->fy)
//                ->select(
//                    'SP.sp_id', 'SP.sp_institution',
//                    'T.t_id', 'T.t_num', 'T.t_text',
//                    'G.g_id', 'G.g_num', 'G.g_text',
//                    'O.o_id', 'O.o_num', 'O.o_text',
//                    'I.i_id', 'I.i_num', 'I.i_text', 'I.i_type', 'I.i_value', 'I.i_FY',
//                    DB::raw('NULL as iv_value') // No iv_value when Todos is selected
//                );
//        }else {
//                $query = DB::table('strategic_plans as SP')
//                    ->join('topics as T', 'SP.sp_id', '=', 'T.sp_id')
//                    ->join('goals as G', 'T.t_id', '=', 'G.t_id')
//                    ->join('objectives as O', 'G.g_id', '=', 'O.g_id')
//                    ->join('indicators as I', 'O.o_id', '=', 'I.o_id')
//                    ->join('indicator_values as IV', 'I.i_id', '=', 'IV.iv_ind_id')
//                    ->join('role_requests as RR', 'IV.iv_u_id', '=', 'RR.user_id')
//                    ->where('SP.sp_id', $this->sp_id)
//                    ->where('I.i_FY', $this->fy)
//                    ->where('RR.department', $this->department)
//                    ->select(
//                        'SP.sp_id', 'SP.sp_institution',
//                        'T.t_id', 'T.t_num', 'T.t_text',
//                        'G.g_id', 'G.g_num', 'G.g_text',
//                        'O.o_id', 'O.o_num', 'O.o_text',
//                        'I.i_id', 'I.i_num', 'I.i_text', 'I.i_type', 'I.i_value', 'I.i_FY',
//                        DB::raw("GROUP_CONCAT(DISTINCT IV.iv_value SEPARATOR ', ') as iv_value")
//                    )
//                    ->groupBy(
//                        'SP.sp_id', 'SP.sp_institution',
//                        'T.t_id', 'T.t_num', 'T.t_text',
//                        'G.g_id', 'G.g_num', 'G.g_text',
//                        'O.o_id', 'O.o_num', 'O.o_text',
//                        'I.i_id', 'I.i_num', 'I.i_text', 'I.i_type', 'I.i_value', 'I.i_FY'
//                    );
//            }
//
//
//            // Filters for objectives, goals, topics
//        if (!empty($this->objectives)) {
//            $query->whereIn('O.o_id', $this->objectives);
//        } elseif (!empty($this->goals)) {
//            $query->whereIn('G.g_id', $this->goals);
//        } elseif (!empty($this->topics)) {
//            $query->whereIn('T.t_id', $this->topics);
//        }
//
//        $data = $query->get();
//
//        // Format each item into structured display strings
//        foreach ($data as $item) {
//            $item->asuntos = 'Asunto ' . $item->t_num . ': ' . $item->t_text;
//            $item->metas = 'Meta ' . $item->g_num . ': ' . $item->g_text;
//            $item->objetivos = 'Objetivo ' . $item->t_num . '.' . $item->g_num . '.' . $item->o_num . ': ' . $item->o_text;
//            $item->indicadores = 'Indicador ' . $item->t_num . '.' . $item->g_num . '.' . $item->o_num . '.' . $item->i_num . ': ' . $item->i_text;
//        }
//
//        return $this->pivotData($data);
//    }
//
//    /**
//     * Defines the column headers in the Excel file.
//     *
//     * @return array
//     */
//
//    public function headings(): array
//    {
//        return ['Asuntos', 'Metas', 'Objetivos', 'Indicadores', 'Valor de Indicador', 'FY'];
//    }
//
//    /**
//     * Transforms grouped raw data into a flat, printable structure (a pivot table) for the spreadsheet.
//     *
//     * @param Collection $data
//     * @return Collection
//     */
//    private function pivotData(Collection $data)
//    {
//        $grouped = $data->groupBy('asuntos');
//
//        $pivotTable = [];
//        foreach ($grouped as $institution => $items) {
//            foreach ($items as $item) {
//                $pivotTable[] = [
//                    'Asuntos' => $item->asuntos,
//                    'Metas' => $item->metas,
//                    'Objetivos' => $item->objetivos,
//                    'Indicadores' => $item->indicadores,
////                    'Valor de Indicador' => $item->i_value,
//                    'Valor de Indicador' => $this->department === "Todos" ? $item->i_value : $item->iv_value,
//                    'FY' => $item->i_FY
//                ];
//            }
//        }
//
//        return collect($pivotTable);
//    }
//
//    /**
//     * Applies styling to the Excel spreadsheet (header, alignment, column width).
//     *
//     * @param \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet $sheet
//     * @return mixed
//     */
//    public function styles($sheet)
//    {
//        // Elimino la columna de FY ?
//
//        // Style headers
//        $sheet->getStyle('A1:F1')->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
//        $sheet->getStyle('A1:F1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
//        $sheet->getStyle('A1:F1')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
//        $sheet->getStyle('A1:F1')->getFont()->setBold(true);
//
//        // Style cells
//        // Wrap text, set column width, and align text to the left and center
//        $lastRow = $sheet->getHighestRow();
//        foreach (range('A', 'F') as $col) {
//            $sheet->getStyle("{$col}2:{$col}{$lastRow}")
//                ->getAlignment()
//                ->setWrapText(true);
//
//            $sheet->getStyle("{$col}2:{$col}{$lastRow}")
//                ->getAlignment()
//                ->setVertical(Alignment::VERTICAL_CENTER)
//                ->setHorizontal(Alignment::HORIZONTAL_LEFT);
//
//            // Column width set to 40
//            $sheet->getColumnDimension($col)->setWidth(40);
//        }
//
//        return $sheet;
//    }
//
//    /**
//     * Registers Excel sheet-level events, including merging cells with same value.
//     *
//     * @return array
//     */
//    public function registerEvents(): array
//    {
//        return [
//            AfterSheet::class => function (AfterSheet $event) {
//                $sheet = $event->sheet;
//                $rowCount = $sheet->getHighestRow();
//                $startRow = 2;
//
//                // Merge cells vertically when content is the same (Asuntos, Metas, Objetivos)
//                for ($col = 1; $col <= 3; $col++) {
//                    $lastValue = null;
//                    $startMergeRow = null;
//                    $columnLetter = Coordinate::stringFromColumnIndex($col);
//
//                    for ($row = $startRow; $row <= $rowCount; $row++) {
//                        $currentValue = $sheet->getCell($columnLetter . $row)->getValue();
//
//                        if ($currentValue == $lastValue) {
//                            $endMergeRow = $row;
//                        } else {
//                            if ($startMergeRow !== null && $startMergeRow < $row - 1) {
//                                $sheet->mergeCells("{$columnLetter}{$startMergeRow}:{$columnLetter}" . ($row - 1));
//                            }
//
//                            $startMergeRow = $row;
//                            $lastValue = $currentValue;
//                        }
//                    }
//
//                    if ($startMergeRow !== null && $startMergeRow < $rowCount) {
//                        $sheet->mergeCells("{$columnLetter}{$startMergeRow}:{$columnLetter}{$rowCount}");
//                    }
//                }
//            }
//        ];
//    }
//
//    /**
//     * Returns the name of the Excel sheet based on department and fiscal year.
//     *
//     * @return string
//     */
//    public function title(): string
//    {
//        if ($this->department === "Todos"){
//            return $this->fy;  // This sets the sheet name as the Fiscal Year (FY) only
//        }
//        else return $this->department.' '.$this->fy; // This sets the sheet name as the Department and FY
//    }
//
//}
//
//
//
//


namespace App\Exports;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class StrategicPlanExport implements WithMultipleSheets
{
    protected $sp_id, $fy, $department, $topics, $goals, $objectives;

    public function __construct($sp_id, $fy, $department, $topics = [], $goals = [], $objectives = [])
    {
        $this->sp_id = $sp_id;
        $this->fy = $fy;
        $this->department = $department;
        $this->topics = $topics;
        $this->goals = $goals;
        $this->objectives = $objectives;
    }

    public function sheets(): array
    {
        return [
            $this->indicatorsSheet(),
            $this->documentsSheet()
        ];
    }

    protected function indicatorsSheet()
    {
        return new class(
            $this->sp_id,
            $this->fy,
            $this->department,
            $this->topics,
            $this->goals,
            $this->objectives
        ) implements
            \Maatwebsite\Excel\Concerns\FromCollection,
            \Maatwebsite\Excel\Concerns\WithHeadings,
            \Maatwebsite\Excel\Concerns\WithTitle,
            \Maatwebsite\Excel\Concerns\WithEvents,
            \Maatwebsite\Excel\Concerns\WithStyles {
            protected $sp_id, $fy, $department, $topics, $goals, $objectives;

            public function __construct($sp_id, $fy, $department, $topics, $goals, $objectives)
            {
                $this->sp_id = $sp_id;
                $this->fy = $fy;
                $this->department = $department;
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
                    ->where('I.i_FY', $this->fy);

                if ($this->department === "Todos") {
                    $query->select(
                        'SP.sp_id', 'SP.sp_institution',
                        'T.t_id', 'T.t_num', 'T.t_text',
                        'G.g_id', 'G.g_num', 'G.g_text',
                        'O.o_id', 'O.o_num', 'O.o_text',
                        'I.i_id', 'I.i_num', 'I.i_text', 'I.i_type', 'I.i_value', 'I.i_FY',
                        DB::raw('NULL as iv_value')
                    );
                } else {
                    $query->join('indicator_values as IV', 'I.i_id', '=', 'IV.iv_ind_id')
                        ->join('role_requests as RR', 'IV.iv_u_id', '=', 'RR.user_id')
                        ->where('RR.department', $this->department)
                        ->select(
                            'SP.sp_id', 'SP.sp_institution',
                            'T.t_id', 'T.t_num', 'T.t_text',
                            'G.g_id', 'G.g_num', 'G.g_text',
                            'O.o_id', 'O.o_num', 'O.o_text',
                            'I.i_id', 'I.i_num', 'I.i_text', 'I.i_type', 'I.i_value', 'I.i_FY',
                            DB::raw("GROUP_CONCAT(DISTINCT IV.iv_value SEPARATOR ', ') as iv_value")
                        )
                        ->groupBy(
                            'SP.sp_id', 'SP.sp_institution',
                            'T.t_id', 'T.t_num', 'T.t_text',
                            'G.g_id', 'G.g_num', 'G.g_text',
                            'O.o_id', 'O.o_num', 'O.o_text',
                            'I.i_id', 'I.i_num', 'I.i_text', 'I.i_type', 'I.i_value', 'I.i_FY'
                        );
                }

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

//                return collect($data)->map(function ($item) {
//                    return [
//                        $item->asuntos,
//                        $item->metas,
//                        $item->objetivos,
//                        $item->indicadores,
//                        $this->department === "Todos" ? $item->i_value : $item->iv_value,
//                        $item->i_FY
//                    ];
//                });
                return collect($data)->map(function ($item) {
                    $rawValue = $this->department === "Todos" ? $item->i_value : $item->iv_value;

                    // Handle comma-separated iv_values for departments (not Todos)
                    if ($this->department !== "Todos" && $rawValue !== null) {
                        $values = array_map('trim', explode(',', $rawValue));

                        // Check if all values are numeric, if so, sum them
                        if (count($values) > 1 && collect($values)->every(fn($v) => is_numeric($v))) {
                            $finalValue = array_sum($values);
                        } else {
                            $finalValue = implode(', ', $values);
                        }
                    } else {
                        $finalValue = $rawValue;
                    }

                    return [
                        $item->asuntos,
                        $item->metas,
                        $item->objetivos,
                        $item->indicadores,
                        $finalValue,
                        $item->i_FY
                    ];
                });

            }

            public function headings(): array
            {
                return ['Asuntos', 'Metas', 'Objetivos', 'Indicadores', 'Valor de Indicador', 'FY'];
            }

            public function title(): string
            {
                return $this->department === "Todos" ? $this->fy : $this->department . ' ' . $this->fy;
            }

            public function styles($sheet)
            {
                $sheet->getStyle('A1:F1')->getFont()->setBold(true);
                foreach (range('A', 'F') as $col) {
                    $sheet->getColumnDimension($col)->setWidth(40);
                }
            }

//            public function registerEvents(): array
//            {
//                return [
//                    \Maatwebsite\Excel\Events\AfterSheet::class => function ($event) {
//                        $sheet = $event->sheet;
//                        $lastRow = $sheet->getHighestRow();
//                        foreach (range('A', 'F') as $col) {
//                            $sheet->getStyle("{$col}2:{$col}{$lastRow}")
//                                ->getAlignment()->setWrapText(true)
//                                ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)
//                                ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
//                        }
//                    }
//                ];
//            }
            public function registerEvents(): array
            {
                return [
                    \Maatwebsite\Excel\Events\AfterSheet::class => function ($event) {
                        $sheet = $event->sheet->getDelegate();
                        $highestRow = $sheet->getHighestRow();

                        foreach (range('A', 'C') as $col) { // A = Asuntos, B = Metas, C = Objetivos
                            $mergeStart = 2; // Skip the heading (row 1)
                            $previousValue = $sheet->getCell("$col$mergeStart")->getValue();

                            for ($row = 3; $row <= $highestRow + 1; $row++) {
                                $currentValue = $sheet->getCell("$col$row")->getValue();

                                if ($currentValue !== $previousValue || $row === $highestRow + 1) {
                                    $mergeEnd = $row - 1;
                                    if ($mergeEnd > $mergeStart) {
                                        $sheet->mergeCells("$col$mergeStart:$col$mergeEnd");
                                        $sheet->getStyle("$col$mergeStart")->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
                                    }
                                    $mergeStart = $row;
                                    $previousValue = $currentValue;
                                }
                            }
                        }

                        // Additional styles for all columns
                        foreach (range('A', 'F') as $col) {
                            $sheet->getStyle("{$col}2:{$col}{$highestRow}")
                                ->getAlignment()->setWrapText(true)
                                ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)
                                ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
                        }
                    }
                ];
            }
        };

    }

    protected function documentsSheet()
    {
        return new class($this->sp_id, $this->fy, $this->department) implements
            \Maatwebsite\Excel\Concerns\FromCollection,
            \Maatwebsite\Excel\Concerns\WithHeadings,
            \Maatwebsite\Excel\Concerns\WithTitle,
            \Maatwebsite\Excel\Concerns\WithMapping,
            \Maatwebsite\Excel\Concerns\WithEvents
        {
            protected $sp_id, $fy, $department;

            public function __construct($sp_id, $fy, $department)
            {
                $this->sp_id = $sp_id;
                $this->fy = $fy;
                $this->department = $department;
            }

            public function collection()
            {
                $query = DB::table('indicators as I')
                    ->join('objectives as O', 'I.o_id', '=', 'O.o_id')
                    ->join('goals as G', 'O.g_id', '=', 'G.g_id')
                    ->join('topics as T', 'G.t_id', '=', 'T.t_id')
                    ->where('T.sp_id', $this->sp_id)
                    ->where('I.i_FY', $this->fy);

                if ($this->department === "Todos") {
                    $query->select(
                        'T.t_num', 'G.g_num', 'O.o_num', 'I.i_num', 'I.i_value as doc_value'
                    );
                } else {
                    $query->join('indicator_values as IV', 'I.i_id', '=', 'IV.iv_ind_id')
                        ->join('role_requests as RR', 'IV.iv_u_id', '=', 'RR.user_id')
                        ->where('RR.department', $this->department)
                        ->select(
                            'T.t_num', 'G.g_num', 'O.o_num', 'I.i_num', 'IV.iv_value as doc_value'
                        );
                }

                return $query->get()
                    ->flatMap(function ($row) {
                        if (!$row->doc_value || !str_contains($row->doc_value, '.pdf')) {
                            return collect();
                        }

                        return collect(explode(',', $row->doc_value))->map(function ($doc) use ($row) {
                            return (object)[
                                'indicator' => "{$row->t_num}.{$row->g_num}.{$row->o_num}.{$row->i_num}",
                                'doc' => trim($doc)
                            ];
                        });
                    });
            }

            public function map($row): array
            {
                return [
                    $row->indicator,
                    '=HYPERLINK("' . asset("storage/documents/{$row->doc}") . '", "' . $row->doc . '")'
                ];
            }

            public function headings(): array
            {
                return ['Indicador', 'Documento'];
            }

            public function title(): string
            {
                return 'Documentos';
            }

            public function registerEvents(): array
            {
                return [
                    \Maatwebsite\Excel\Events\AfterSheet::class => function ($event) {
                        $sheet = $event->sheet->getDelegate();
                        $highestRow = $sheet->getHighestRow();

                        // Apply bold headers
                        $sheet->getStyle('A1:B1')->getFont()->setBold(true);

                        // Column widths
                        $sheet->getColumnDimension('A')->setWidth(25);
                        $sheet->getColumnDimension('B')->setWidth(50);

                        // Style all links in column B (Documento)
                        for ($row = 2; $row <= $highestRow; $row++) {
                            $sheet->getStyle("B$row")->getFont()
                                ->setUnderline(true)
                                ->getColor()->setRGB('0000FF'); // Blue
                        }
                    }
                ];
            }

        };
    }

}
