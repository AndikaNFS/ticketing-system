<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ImageBuilding extends Model
{
    protected $fillable = [
        'building_id',
        'path',
    ];

    public function building()
    {
        return $this->belongsTo(Building::class);
    }


}
