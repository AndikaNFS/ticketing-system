<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'position',
    ];

    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }
    public function outlets()
    {
        return $this->hasMany(Outlet::class);
    }
}
