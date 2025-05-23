<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $fillable = [
        'employee_id',
        'date',
        'status',
        'remarks',
    ];

    public function employees()
    {
        return $this->belongsTo(Employee::class);
    }
}
