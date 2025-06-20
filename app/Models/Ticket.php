<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $fillable = [
        'ticketing', 
        'problem', 
        'outlet_id',
        'status', 
        'it_name', 
        'date_finish',
        'start_date',
        'lama_pengerjaan',
        'user',
        'description'
    ];

    public function visits()
    {
        return $this->hasMany(Visit::class);
    }

    public function images()
    {
        return $this->hasMany(Image::class);
    }
    public function outlet()
    {
        return $this->belongsTo(Outlet::class);
    }

    public function scopeFilterStatus($query, $status)
    {
        if ($status && in_array($status, ['Open', 'InProgress', 'Done', 'Cancel'])) {
            return $query->where('status', $status);
        }
        return $query;
    }
}
