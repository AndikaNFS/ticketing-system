<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Visit extends Model
{
    protected $fillable = [
        'pic',
        'tanggal_visit',
        'ticket_id',
        'outlet_id',
        'status',
        'description',
    ];

    public function outlet() {
        return $this->belongsTo(Outlet::class);
    }
    public function ticket() {
        return $this->belongsTo(Ticket::class);
    }
    public function images()
    {
        return $this->hasMany(Image::class);
    }
}
