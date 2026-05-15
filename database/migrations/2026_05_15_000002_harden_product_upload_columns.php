<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (!Schema::hasTable('products')) {
            return;
        }

        $driver = DB::getDriverName();

        if (Schema::hasColumn('products', 'image_path')) {
            if ($driver === 'mysql') {
                DB::statement('ALTER TABLE products MODIFY image_path TEXT NULL');
            } elseif ($driver === 'pgsql') {
                DB::statement('ALTER TABLE products ALTER COLUMN image_path TYPE TEXT');
            }
        }

        if (Schema::hasColumn('products', 'sizes')) {
            if ($driver === 'mysql') {
                DB::statement('ALTER TABLE products MODIFY sizes JSON NULL');
            } elseif ($driver === 'pgsql') {
                DB::statement('ALTER TABLE products ALTER COLUMN sizes TYPE JSON USING sizes::json');
            }
        }
    }

    public function down(): void
    {
        if (!Schema::hasTable('products') || !Schema::hasColumn('products', 'image_path')) {
            return;
        }

        $driver = DB::getDriverName();

        if ($driver === 'mysql') {
            DB::statement('ALTER TABLE products MODIFY image_path VARCHAR(255) NULL');
        } elseif ($driver === 'pgsql') {
            DB::statement('ALTER TABLE products ALTER COLUMN image_path TYPE VARCHAR(255)');
        }
    }
};
