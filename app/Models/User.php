<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'status',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Relationships
    public function profile()
    {
        return $this->hasOne(SellerBuyerProfile::class);
    }

    public function riceListings()
    {
        return $this->hasMany(RiceListing::class, 'seller_id');
    }

    public function purchasedOrders()
    {
        return $this->hasMany(Order::class, 'buyer_id');
    }

    public function soldOrders()
    {
        return $this->hasMany(Order::class, 'seller_id');
    }

    public function givenFeedback()
    {
        return $this->hasMany(Feedback::class, 'reviewer_id');
    }

    public function receivedFeedback()
    {
        return $this->hasMany(Feedback::class, 'reviewee_id');
    }

    public function systemLogs()
    {
        return $this->hasMany(SystemLog::class);
    }

    // Helper methods
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isSeller()
    {
        return $this->role === 'seller';
    }

    public function isBuyer()
    {
        return $this->role === 'buyer';
    }

    public function isApproved()
    {
        return $this->status === 'approved';
    }

    public function isPending()
    {
        return $this->status === 'pending';
    }
}
