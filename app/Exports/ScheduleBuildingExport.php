<?php

namespace App\Exports;

use App\Models\ScheduleBuilding;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

class ScheduleBuildingExport implements FromView
{
    protected $bulan;
    
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        // return ScheduleBuilding::all();
    }

    public function __construct($bulan)
    {
        $this->bulan = $bulan;
    }

    public function view(): View
     {
        $schedules = app(\App\Http\Controllers\ScheduleBuildingController::class)->getScheduleData($this->bulan);
        return view('building.schedules.exports.schedule-excel', [
            'schedules' => $schedules,
            'bulan' => $this->bulan,
        ]);
     }
}
