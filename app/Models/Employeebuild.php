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
        'phone_number',
        'email',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function schedulebuildings()
    {
        return $this->hasMany(ScheduleBuilding::class);
    }

    public function outlets()
    {
        return $this->hasMany(Outlet::class);
    }
    
    public function buildings()
    {
        return $this->hasMany(Building::class);
    }   

    public function visitbuildings()
    {
        return $this->hasMany(VisitBuilding::class);
    }
    
}
