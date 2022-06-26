<?php

namespace App\Exports;

use App\Models\CleaningSchedule;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ScheduleExport implements FromView,WithStyles,WithColumnWidths
{
    public function view(): View
    {
        return view('exports.cleaningschedule', [
            'schedules' => CleaningSchedule::with('user1','user2')->get()
        ]);
    }


    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text size 16.
            1    => ['font' => ['bold' => true,'size' => 16]]
        ];

    }

    public function columnWidths(): array
    {
        return [
            'A' => 20,
            'B' => 25,
            'C' => 25,
        ];
    }

}
