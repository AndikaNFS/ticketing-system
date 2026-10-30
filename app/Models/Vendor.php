<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    protected $fillable = [
        'name',
        'alamat',
        'no_telp',
        'user',
    ];

    public function buildings()
    {
        return $this->hasMany(Building::class);
    }
}
