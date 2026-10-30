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
        'is_active',
        'phone_number',
        'email',
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }
    public function outlets()
    {
        return $this->hasMany(Outlet::class);
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
    public function visits()
    {
        return $this->hasMany(Visit::class);
    }
}
