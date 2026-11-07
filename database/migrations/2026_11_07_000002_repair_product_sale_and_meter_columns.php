<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (! Schema::hasColumn('products', 'sold_by_meter')) {
            Schema::table('products', function (Blueprint $table) {
                $table->boolean('sold_by_meter')->default(false)->after('category');
            });
        }

        if (! Schema::hasColumn('products', 'old_price')) {
            Schema::table('products', function (Blueprint $table) {
                $table->decimal('old_price', 10, 2)->nullable()->after('price');
            });
        }
    }

    public function down(): void
    {
        // Keep product pricing and meter data intact when rolling back this repair.
    }
};
