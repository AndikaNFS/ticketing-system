<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AssetTransferImage extends Model
{
    protected $fillable = [
        'inventory_transfer_id',
        'image_path',
        'image_type',
    ];

    public function inventoryTransfer()
    {
        return $this->belongsTo(InventoryTransfer::class);
    }

    public function getImageTypeLabelAttribute(): string
    {
        return match ($this->image_type) {
            'handover' => 'Photo Handover',
            'condition' => 'Photo Condition',
            default => 'Lainnya',
        };
    }
}
