<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Building extends Model
{
    protected $fillable = [
        'ticketing',
        'problem',
        'description',
        'vendor_id',
        'outlet_id',
        'pic_id',
        'user',
        'start_date',
        'finish_date',
        'work_duration',
        'status',
    ];

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    public function outlet()
    {
        return $this->belongsTo(Outlet::class);
    }

    public function pic()
    {
        return $this->belongsTo(Pic::class);
    }
}
