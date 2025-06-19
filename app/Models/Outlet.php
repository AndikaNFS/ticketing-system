<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Outlet extends Model
{
    protected $fillable = [
        'name',
        'area',
        'employee_id',
        'it_name',
        'pic',
        'location',
    ];

    public function visits()
    {
        return $this->hasMany(Visit::class);
    }
    public function areaits()
    {
        return $this->hasMany(Areait::class);
    }

    public function buildings()
    {
        return $this->hasMany(Building::class);
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
    
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
    // public function daily_reports()
    // {
    //     return $this->hasMany(DailyReport::class);
    // }


}
