<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Product extends Model
{
// app/Models/Product.php
protected $fillable = [
  'name','slug','price','old_price','description','image_path',
  'is_active','stock','category','sizes','subcategory','sku'
];

protected $casts = [
  'is_active' => 'boolean',
  'sizes'     => 'array',
];

   

    public function getImageUrlAttribute(): string
    {
        return $this->image_path ? Storage::url($this->image_path) : asset('images/placeholder.png');
    }
       protected static function booted()
    {
        static::creating(function (Product $p) {
            if (empty($p->sku)) {
                $p->sku = self::generateSku($p->name);
            }
        });
    }

    public static function generateSku(?string $name): string
    {
        $base = strtoupper(Str::slug($name ?? 'PRD', '-'));     // p.sh. MODERN-ROSE
        $base = preg_replace('/[^A-Z0-9\-]/', '', $base);
        $base = substr($base, 0, 12);                           // max 12 char baze

        do {
            $suffix = '-'.strtoupper(Str::random(4));           // -AB12
            $sku = ($base ?: 'PRD').$suffix;
        } while (self::where('sku', $sku)->exists());

        return $sku;
    }
}
