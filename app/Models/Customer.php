<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = [
        'name',
        'phone',
        'email',
        'address',
        'city',
        'notes',
        'last_purchase_at',
    ];

    protected $casts = [
        'last_purchase_at' => 'datetime',
    ];

    public function purchases()
    {
        return $this->hasMany(CustomerPurchase::class);
    }

    public function receipts()
    {
        return $this->hasMany(CustomerReceipt::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
