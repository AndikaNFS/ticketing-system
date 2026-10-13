<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InventoryRepair extends Model
{
    protected $fillable = [
        'inventory_id',
        'asset_id',
        'outlet_id',
        'repair_date',
        'status',
        'description',
        'cost',
        'completed_at',
    ];

    protected $casts = [
        'repair_date' => 'datetime',
        'completed_at' => 'datetime',
        'cost' => 'decimal:2',
    ];

    public function inventory()
    {
        return $this->belongsTo(Inventory::class);
    }

    public function outlet()
    {
        return $this->belongsTo(Outlet::class);
    }

    public function asset()
    {
        return $this->belongsTo(Asset::class);
    }
}
