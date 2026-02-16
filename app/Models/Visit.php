<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Visit extends Model
{
    protected $fillable = [
        'pic',
        'employee_id',
        'tanggal_visit',
        'ticket_id',
        'outlet_id',
        'status',
        'description',
    ];

    public function outlet() {
        return $this->belongsTo(Outlet::class);
    }
    public function ticket() {
        return $this->belongsTo(Ticket::class);
    }
    public function images()
    {
        return $this->hasMany(ImageVisit::class);
    }
    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }
}
