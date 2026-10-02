<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InventoryTransfer extends Model
{
    protected $fillable = [
        'inventory_id',
        'asset_id',
        'from_outlet_id',
        'to_outlet_id',
        'quantity',
        'transfer_date',
        'status',
        'description',
        'created_by',
    ];

    public function inventory()
    {
        return $this->belongsTo(Inventory::class);
    }

    public function fromOutlet()
    {
        return $this->belongsTo(Outlet::class, 'from_outlet_id');
    }

    public function toOutlet()
    {
        return $this->belongsTo(Outlet::class, 'to_outlet_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
