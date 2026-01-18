<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Krijo index-e vetëm nëse ekzistojnë kolonat dhe nuk janë krijuar më parë
        if (Schema::hasTable('users')) {
            Schema::table('users', function (Blueprint $table) {
                if (Schema::hasColumn('users', 'name')) {
                    // nëse nuk ekziston index-i, krijoje
                    $hasNameIndex = DB::selectOne("
                        SELECT COUNT(1) AS c
                        FROM information_schema.statistics
                        WHERE table_schema = DATABASE()
                          AND table_name = 'users'
                          AND index_name = 'users_name_index'
                    ")->c ?? 0;

                    if (!$hasNameIndex) {
                        $table->index('name');
                    }
                }

                if (Schema::hasColumn('users', 'email')) {
                    $hasEmailIndex = DB::selectOne("
                        SELECT COUNT(1) AS c
                        FROM information_schema.statistics
                        WHERE table_schema = DATABASE()
                          AND table_name = 'users'
                          AND index_name = 'users_email_index'
                    ")->c ?? 0;

                    if (!$hasEmailIndex) {
                        $table->index('email');
                    }
                }

                if (Schema::hasColumn('users', 'role')) {
                    $hasRoleIndex = DB::selectOne("
                        SELECT COUNT(1) AS c
                        FROM information_schema.statistics
                        WHERE table_schema = DATABASE()
                          AND table_name = 'users'
                          AND index_name = 'users_role_index'
                    ")->c ?? 0;

                    if (!$hasRoleIndex) {
                        $table->index('role');
                    }
                }
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('users')) {
            // Per MySQL 8+: DROP INDEX IF EXISTS
            DB::statement("DROP INDEX IF EXISTS users_name_index ON users");
            DB::statement("DROP INDEX IF EXISTS users_email_index ON users");
            DB::statement("DROP INDEX IF EXISTS users_role_index ON users");
        }
    }
};

