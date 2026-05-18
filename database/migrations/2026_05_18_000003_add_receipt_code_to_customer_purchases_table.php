<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('customer_purchases')) {
            return;
        }

        Schema::table('customer_purchases', function (Blueprint $table) {
            if (!Schema::hasColumn('customer_purchases', 'receipt_code')) {
                $table->string('receipt_code', 40)->nullable()->after('product_id')->index();
            }
        });

        DB::table('customer_purchases')
            ->whereNotNull('order_id')
            ->whereNull('receipt_code')
            ->orderBy('id')
            ->update(['receipt_code' => DB::raw("CONCAT('ORD-', order_id)")]);

        DB::table('customer_purchases')
            ->whereNull('receipt_code')
            ->orderBy('id')
            ->chunkById(100, function ($purchases) {
                foreach ($purchases as $purchase) {
                    DB::table('customer_purchases')
                        ->where('id', $purchase->id)
                        ->update(['receipt_code' => 'BRL-MAN-'.$purchase->id]);
                }
            });
    }

    public function down(): void
    {
        if (!Schema::hasTable('customer_purchases')) {
            return;
        }

        Schema::table('customer_purchases', function (Blueprint $table) {
            if (Schema::hasColumn('customer_purchases', 'receipt_code')) {
                $table->dropColumn('receipt_code');
            }
        });
    }
};
