<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employeebuild extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'position',
    ];

    public function schedulebuildings()
    {
        return $this->hasMany(ScheduleBuilding::class);
    }

    public function outlets()
    {
        return $this->hasMany(Outlet::class);
    }

    public function visitbuildings()
    {
        return $this->hasMany(VisitBuilding::class);
    }
    
}
