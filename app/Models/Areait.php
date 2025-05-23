<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Areait extends Model
{
    protected $fillable = [
        'area_id',
        'location',
        'it_name',
        'outlet_id',
    ];

    public function outlets() {
        return $this->belongsTo(Outlet::class);
    }
    public function areas() {
        return $this->belongsTo(Area::class);
    }
}
