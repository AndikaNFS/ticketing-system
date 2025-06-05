<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pic extends Model
{
     protected $fillable = [
        'name',
        'no_telp',
    ];

    public function building()
    {
        return $this->hasMany(Building::class);
    }
}
