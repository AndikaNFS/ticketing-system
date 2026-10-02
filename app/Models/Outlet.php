<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Asset;

class Outlet extends Model
{
    protected $fillable = [
        'name',
        'area',
        'employee_id',
        'it_name',
        'pic',
        'location',
    ];

    public function visits()
    {
        return $this->hasMany(Visit::class);
    }
    public function visitbuildings()
    {
        return $this->hasMany(VisitBuilding::class);
    }
    public function areaits()
    {
        return $this->hasMany(Areait::class);
    }

    public function buildings()
    {
        return $this->hasMany(Building::class);
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
    
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function inventories()
    {
        return $this->hasMany(Inventory::class);
    }

    public function sourceInventories()
    {
        return $this->hasMany(Inventory::class, 'source_outlet_id');
    }

    public function assets()
    {
        return $this->hasMany(Asset::class);
    }

    public function assetImages()
    {
        return $this->hasMany(AssetImage::class);
    }

    public function outgoingTransfers()
    {
        return $this->hasMany(InventoryTransfer::class, 'from_outlet_id');
    }

    public function incomingTransfers()
    {
        return $this->hasMany(InventoryTransfer::class, 'to_outlet_id');
    }


}
