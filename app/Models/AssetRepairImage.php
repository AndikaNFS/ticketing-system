<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AssetRepairImage extends Model
{
    protected $fillable = [
        'inventory_repair_id',
        'image_path',
        'image_type',
    ];

    public function inventoryRepair()
    {
        return $this->belongsTo(InventoryRepair::class);
    }

    public function getImageTypeLabelAttribute(): string
    {
        return match ($this->image_type) {
            'Damage' => 'Damage',
            'Process' => 'Repair Process',
            'Result' => 'Results',
            default => 'Lainnya',
        };
    }
}
