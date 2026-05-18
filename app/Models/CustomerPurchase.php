<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerPurchase extends Model
{
    protected $fillable = [
        'customer_id',
        'order_id',
        'product_id',
        'receipt_code',
        'item_name',
        'size',
        'quantity',
        'unit_price',
        'total',
        'purchased_at',
        'notes',
    ];

    protected $casts = [
        'purchased_at' => 'datetime',
        'quantity' => 'integer',
        'unit_price' => 'decimal:2',
        'total' => 'decimal:2',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
