<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InventoryImage extends Model
{
    protected $fillable = [
        'inventory_id',
        'outlet_id',
        'image_path',
    ];

    public function inventory()
    {
        return $this->belongsTo(Inventory::class);
    }

    public function outlet()
    {
        return $this->belongsTo(Outlet::class);
    }
}
