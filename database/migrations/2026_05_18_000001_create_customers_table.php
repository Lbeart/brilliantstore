<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('customers')) {
            Schema::create('customers', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('phone', 60)->nullable()->index();
                $table->string('email')->nullable()->index();
                $table->string('address')->nullable();
                $table->string('city')->nullable();
                $table->text('notes')->nullable();
                $table->timestamp('last_purchase_at')->nullable();
                $table->timestamps();

                $table->index(['name', 'created_at']);
            });
        }

        Schema::table('orders', function (Blueprint $table) {
            if (!Schema::hasColumn('orders', 'customer_id')) {
                $column = $table->foreignId('customer_id')->nullable();
                $column->after(Schema::hasColumn('orders', 'user_id') ? 'user_id' : 'id');
                $column->constrained()->nullOnDelete();
            }
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            if (Schema::hasColumn('orders', 'customer_id')) {
                $table->dropConstrainedForeignId('customer_id');
            }
        });

        Schema::dropIfExists('customers');
    }
};
