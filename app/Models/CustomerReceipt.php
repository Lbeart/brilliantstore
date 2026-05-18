<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerReceipt extends Model
{
    protected $fillable = [
        'customer_id',
        'order_id',
        'code',
        'subtotal',
        'discount',
        'total',
        'paid_amount',
        'balance',
        'payment_method',
        'payment_status',
        'sold_at',
        'notes',
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'discount' => 'decimal:2',
        'total' => 'decimal:2',
        'paid_amount' => 'decimal:2',
        'balance' => 'decimal:2',
        'sold_at' => 'datetime',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function purchases()
    {
        return $this->hasMany(CustomerPurchase::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
