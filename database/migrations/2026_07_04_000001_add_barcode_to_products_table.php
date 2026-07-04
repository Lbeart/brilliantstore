<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('products')) {
            return;
        }

        Schema::table('products', function (Blueprint $table) {
            if (!Schema::hasColumn('products', 'barcode')) {
                $table->string('barcode', 80)->nullable()->unique()->after('sku');
            }
        });

        if (Schema::hasColumn('products', 'barcode')) {
            DB::table('products')
                ->whereNull('barcode')
                ->orderBy('id')
                ->chunkById(100, function ($products) {
                    foreach ($products as $product) {
                        DB::table('products')
                            ->where('id', $product->id)
                            ->update(['barcode' => 'BRL'.str_pad((string) $product->id, 8, '0', STR_PAD_LEFT)]);
                    }
                });
        }
    }

    public function down(): void
    {
        if (!Schema::hasTable('products') || !Schema::hasColumn('products', 'barcode')) {
            return;
        }

        Schema::table('products', function (Blueprint $table) {
            $table->dropUnique(['barcode']);
            $table->dropColumn('barcode');
        });
    }
};
