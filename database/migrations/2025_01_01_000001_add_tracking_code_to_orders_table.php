<?php 
// database/migrations/2025_01_01_000001_add_tracking_code_to_orders_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
       Schema::table('orders', function (Blueprint $table) {
        if (!Schema::hasColumn('orders', 'tracking_code')) {
            $table->string('tracking_code', 32)->nullable()->after('status'); // ❌ pa ->unique()
        }
    });


    }
    public function down(): void {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropUnique(['tracking_code']);
            $table->dropColumn('tracking_code');
        });
    }
};
