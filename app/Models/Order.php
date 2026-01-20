<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number',
        'buyer_id',
        'seller_id',
        'rice_listing_id',
        'quantity',
        'price_per_kg',
        'total_amount',
        'status',
        'delivery_address',
        'contact_number',
        'notes',
        'confirmed_at',
        'delivered_at',
        'completed_at',
    ];

    protected $casts = [
        'price_per_kg' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'confirmed_at' => 'datetime',
        'delivered_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    // Relationships
    public function buyer()
    {
        return $this->belongsTo(User::class, 'buyer_id');
    }

    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    public function riceListing()
    {
        return $this->belongsTo(RiceListing::class);
    }

    public function feedback()
    {
        return $this->hasOne(Feedback::class);
    }

    // Helper methods
    public function generateOrderNumber()
    {
        return 'ORD-' . date('Ymd') . '-' . strtoupper(substr(md5(uniqid()), 0, 6));
    }

    public function markAsCompleted()
    {
        $this->status = 'completed';
        $this->completed_at = now();
        $this->save();
    }
}
