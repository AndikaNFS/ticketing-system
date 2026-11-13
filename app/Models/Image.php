<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $fillable = [
        'ticket_id',
        'visit_id',
        'path',
    ];

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }
    public function visit()
    {
        return $this->belongsTo(Visit::class);
    }
    public function building()
    {
        return $this->belongsTo(Building::class);
    }
}
