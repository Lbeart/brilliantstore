<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Support\ProductImages;
use Illuminate\Support\Str;

class Product extends Model
{
// app/Models/Product.php
protected $fillable = [
  'name','slug','price','old_price','description','image_path',
  'is_active','stock','category','sold_by_meter','sizes','color_variants','subcategory','sku','barcode'
];

protected $casts = [
  'is_active' => 'boolean',
  'sold_by_meter' => 'boolean',
  'sizes'     => 'array',
  'color_variants' => 'array',
];

   

    public function getImageUrlAttribute(): string
    {
        return ProductImages::url($this->image_path, asset('images/placeholder-product.png'), $this);
    }
       protected static function booted()
    {
        static::creating(function (Product $p) {
            if (empty($p->sku)) {
                $p->sku = self::generateSku($p->name);
            }

            if (empty($p->barcode)) {
                $p->barcode = self::generateBarcode();
            }

            if (empty($p->slug) && !empty($p->name)) {
                $p->slug = self::generateSlug($p->name);
            }

            if (!isset($p->is_active)) {
                $p->is_active = true;
            }
        });

        static::updating(function (Product $p) {
            if (!isset($p->is_active)) {
                $p->is_active = true;
            }
        });
    }

    public static function generateSlug(?string $name): string
    {
        $base = Str::slug($name ?? 'product', '-');
        $slug = $base;
        $counter = 1;

        while (self::where('slug', $slug)->exists()) {
            $slug = $base . '-' . $counter;
            $counter++;
        }

        return $slug;
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

    public static function generateBarcode(): string
    {
        do {
            $barcode = 'BRL'.now()->format('ymd').strtoupper(Str::random(5));
        } while (self::where('barcode', $barcode)->exists());

        return $barcode;
    }
}
