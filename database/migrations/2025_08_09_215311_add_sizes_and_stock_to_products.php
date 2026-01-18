<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            if (!Schema::hasColumn('products', 'sizes')) {
                $table->json('sizes')->nullable()->after('price'); // ose vendose ku të duash
            }

            if (!Schema::hasColumn('products', 'stock')) {
                $table->integer('stock')->nullable()->after('price');
            }
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            if (Schema::hasColumn('products', 'sizes')) {
                $table->dropColumn('sizes');
            }
            // Zakonisht mos e hiq stock në down nëse ka qenë më herët në DB
            // nëse je i sigurt që e ke shtuar vetëm me këtë migration, atëherë:
            // if (Schema::hasColumn('products', 'stock')) $table->dropColumn('stock');
        });
    }
};

