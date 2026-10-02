<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    protected $fillable = [
        'inventory_id',
        'outlet_id',
        'serial_number',
        'asset_number',
        'status',
        'placement',
        'entry_date',
    ];

    protected $casts = [
        'entry_date' => 'date',
    ];

    public function inventory()
    {
        return $this->belongsTo(Inventory::class);
    }

    public function outlet()
    {
        return $this->belongsTo(Outlet::class);
    }

    public function images()
    {
        return $this->hasMany(AssetImage::class);
    }

    public function transfers()
    {
        return $this->hasMany(InventoryTransfer::class);
    }

    public function repairs()
    {
        return $this->hasMany(InventoryRepair::class);
    }
}
