<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->index(['is_active', 'category', 'id'], 'products_active_category_id_index');
            $table->index(['is_active', 'category', 'subcategory', 'id'], 'products_active_category_subcategory_id_index');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropIndex('products_active_category_id_index');
            $table->dropIndex('products_active_category_subcategory_id_index');
        });
    }
};
