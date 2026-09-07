<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ImageVisit extends Model
{
    protected $fillable = [
        'visit_id',
        'path',
    ];

    public function visit()
    {
        return $this->belongsTo(Visit::class);
    }
}
