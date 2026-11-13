<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Areait extends Model
{
    protected $fillable = [
        'area_id',
        // 'location',
        'it_name',
        'pic',
        'outlet_id',
        
    ];

    public function outlet() {
        return $this->belongsTo(Outlet::class);
    }
    public function area() {
        return $this->belongsTo(Area::class);
    }
}
