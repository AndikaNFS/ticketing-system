<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VisitBuilding extends Model
{
    protected $fillable = [
        'employeebuild',
        'tanggal_visit',
        'building_id',
        'outlet_id',
        'status',
        'jobdesk',
    ];

    public function outlet() {
        return $this->belongsTo(Outlet::class);
    }
    public function building() {
        return $this->belongsTo(Building::class);
    }
    public function employeebuild() {
        return $this->belongsTo(Employeebuild::class);
    }
    public function images()
    {
        return $this->hasMany(Image::class);
    }
}
