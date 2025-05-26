<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    protected $fillable = [
        'name',
        'location',
    ];

    public function areaits()
    {
        return $this->hasMany(Areait::class);
    }

}
