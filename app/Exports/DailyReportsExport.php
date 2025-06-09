<?php

namespace App\Exports;

use App\Models\DailyReport;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class DailyReportsExport implements FromView
{
    protected $month, $year, $userId;

    public function __construct($month, $year, $userId)
    {
        $this->month = $month;
        $this->year = $year;
        $this->userId = $userId;
    }

    public function view(): View
    {
        $query = DailyReport::where('user_id', $this->userId);

        if ($this->month && $this->year) {
            $query->whereMonth('date', $this->month)
                  ->whereYear('date', $this->year);
        }

        $reports = $query->orderBy('date')->get();

        return view('reports.export.export_excel', compact('reports'));
    }
}
