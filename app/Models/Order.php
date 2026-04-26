<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Schema; 
class Order extends Model
{
    protected $fillable = [
        'user_id','name','phone','email','address','city','zip','notes','payment','total','status','tracking_code'
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
     protected static function booted()
    {
        static::creating(function (Order $order) {
            // Generate tracking code only if the DB has the column.
            try {
                if (Schema::hasColumn('orders', 'tracking_code')) {
                    if (empty($order->tracking_code)) {
                        $order->tracking_code = self::generateTrackingCode();
                    }
                }
            } catch (\Throwable $e) {
                // If schema check fails (DB not migrated/available), skip generating tracking code.
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
