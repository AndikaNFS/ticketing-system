<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ScheduleBuilding extends Model
{
    protected $fillable = [
        'employeebuild_id',
        'date',
        'status',
        'remarks',
    ];

    public function employeebuild()
    {
        return $this->belongsTo(Employeebuild::class);
    }
}
