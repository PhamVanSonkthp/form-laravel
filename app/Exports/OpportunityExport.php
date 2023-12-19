<?php

namespace App\Exports;

use App\Models\Helper;
use App\Models\User;
use App\Models\UserFlight;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Border;

class OpportunityExport implements ShouldAutoSize, FromView,WithEvents
{

    private $request;
    private $model;
    private $queries;
    private $heading;
    private $approvedColums;

    public function __construct($model, $request, $queries = [])
    {
        $this->request = $request;
        $this->model = $model;
        $this->queries = $queries;
    }

    public function view(): View
    {
        $items = $this->model->searchByQuery($this->request, $this->queries);

        return view('administrator.opportunities.export', compact('items'));
    }

    public function registerEvents(): array
    {

        return [
            AfterSheet::class => function (AfterSheet $event) {
                $event->sheet->getDelegate()->getStyle('A3:L3')->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'valign' => 'middle',

                    ],

                ]);
                $event->sheet->getStyle('A3:L3')->getFill()->applyFromArray(['fillType' => 'solid','rotation' => 0, 'color' => ['rgb' => 'd3d3d3'],]);
                $event->sheet->getDelegate()->getStyle('A1:L1')->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'size' => 16,
                    ]
                ]);
                $event->sheet->getDelegate()->getColumnDimension('A')->setWidth(50);
                $cellRange = 'A2:L2'; // All headers
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(14);
                $lastColumn = 'L';
                $lastRow = $event->sheet->getHighestRow();
                $range = 'A1:' . $lastColumn . $lastRow;
                $event->sheet->getStyle($range)->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['argb' => '#000000'],
                        ],
                    ],
                ]);
            }
        ];
    }

}
