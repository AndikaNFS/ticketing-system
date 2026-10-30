<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    protected $fillable = [
        'category_id',
        'outlet_id',
        'sources_outlet_id',
        'device',
        'type',
        'brand',
        'is_tracked',
        'quantity',
        'placement',
        'entry_date',
        'description',
        'import_ref',
    ];

    protected $casts = [
        'is_tracked' => 'boolean',
        'entry_date' => 'date',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function outlet()
    {
        return $this->belongsTo(Outlet::class);
    }

    public function sourceOutlet()
    {
        return $this->belongsTo(Outlet::class, 'sources_outlet_id');
    }

    public function assets()
    {
        return $this->hasMany(Asset::class);
    }

    public function images()
    {
        return $this->hasMany(InventoryImage::class);
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
