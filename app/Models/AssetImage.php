<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssetImage extends Model
{
    protected $fillable = [
        'asset_id',
        'outlet_id',
        'image_path',
    ];

    public function asset()
    {
        return $this->belongsTo(Asset::class);
    }

    public function outlet()
    {
        return $this->belongsTo(Outlet::class);
    }
}
