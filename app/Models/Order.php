<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str; 
class Order extends Model
{
    protected $fillable = [
        'name','phone','email','address','city','zip','notes','payment','total','status','tracking_code'
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
     protected static function booted()
    {
        static::creating(function (Order $order) {
            if (empty($order->tracking_code)) {
                $order->tracking_code = self::generateTrackingCode();
            }
        });
    }

    public static function generateTrackingCode(): string
    {
        do {
            $code = 'BRL-'.strtoupper(Str::random(4)).'-'.strtoupper(Str::random(4));
        } while (self::where('tracking_code', $code)->exists());

        return $code;
    }
}
