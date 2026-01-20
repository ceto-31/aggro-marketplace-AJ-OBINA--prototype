<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiceListing extends Model
{
    use HasFactory;

    protected $fillable = [
        'seller_id',
        'rice_variety',
        'price_per_kg',
        'quantity_available',
        'unit',
        'description',
        'location',
        'harvest_date',
        'quality_grade',
        'image_path',
        'status',
    ];

    protected $casts = [
        'price_per_kg' => 'decimal:2',
    ];

    // Relationships
    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    // Helper methods
    public function isAvailable()
    {
        return $this->status === 'active' && $this->quantity_available > 0;
    }

    public function reduceStock($quantity)
    {
        $this->quantity_available -= $quantity;
        if ($this->quantity_available <= 0) {
            $this->status = 'sold_out';
        }
        $this->save();
    }
}
