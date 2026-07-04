<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('customer_receipts')) {
            return;
        }

        Schema::table('customer_receipts', function (Blueprint $table) {
            if (!Schema::hasColumn('customer_receipts', 'receipt_type')) {
                $table->string('receipt_type', 30)->default('regular')->after('code')->index();
            }

            if (!Schema::hasColumn('customer_receipts', 'source')) {
                $table->string('source', 30)->default('manual')->after('receipt_type')->index();
            }
        });
    }

    public function down(): void
    {
        if (!Schema::hasTable('customer_receipts')) {
            return;
        }

        Schema::table('customer_receipts', function (Blueprint $table) {
            if (Schema::hasColumn('customer_receipts', 'source')) {
                $table->dropColumn('source');
            }

            if (Schema::hasColumn('customer_receipts', 'receipt_type')) {
                $table->dropColumn('receipt_type');
            }
        });
    }
};
