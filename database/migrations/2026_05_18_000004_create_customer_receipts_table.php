<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('customer_receipts')) {
            Schema::create('customer_receipts', function (Blueprint $table) {
                $table->id();
                $table->foreignId('customer_id')->constrained()->cascadeOnDelete();
                $table->foreignId('order_id')->nullable()->constrained()->nullOnDelete();
                $table->string('code', 40)->unique();
                $table->decimal('subtotal', 10, 2)->default(0);
                $table->decimal('discount', 10, 2)->default(0);
                $table->decimal('total', 10, 2)->default(0);
                $table->decimal('paid_amount', 10, 2)->default(0);
                $table->decimal('balance', 10, 2)->default(0);
                $table->string('payment_method', 30)->default('cash');
                $table->string('payment_status', 30)->default('paid');
                $table->timestamp('sold_at')->nullable();
                $table->text('notes')->nullable();
                $table->timestamps();

                $table->index(['customer_id', 'sold_at']);
            });
        }

        if (Schema::hasTable('customer_purchases')) {
            Schema::table('customer_purchases', function (Blueprint $table) {
                if (!Schema::hasColumn('customer_purchases', 'customer_receipt_id')) {
                    $table->foreignId('customer_receipt_id')
                        ->nullable()
                        ->after('customer_id')
                        ->constrained()
                        ->nullOnDelete();
                }
            });

            $this->backfillReceipts();
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('customer_purchases')) {
            Schema::table('customer_purchases', function (Blueprint $table) {
                if (Schema::hasColumn('customer_purchases', 'customer_receipt_id')) {
                    $table->dropConstrainedForeignId('customer_receipt_id');
                }
            });
        }

        Schema::dropIfExists('customer_receipts');
    }

    private function backfillReceipts(): void
    {
        DB::table('customer_purchases')
            ->select('customer_id', 'order_id', 'receipt_code')
            ->whereNotNull('receipt_code')
            ->groupBy('customer_id', 'order_id', 'receipt_code')
            ->orderBy('customer_id')
            ->chunk(100, function ($groups) {
                foreach ($groups as $group) {
                    if (!$group->receipt_code) {
                        continue;
                    }

                    $items = DB::table('customer_purchases')
                        ->where('customer_id', $group->customer_id)
                        ->where('receipt_code', $group->receipt_code)
                        ->get();

                    if ($items->isEmpty()) {
                        continue;
                    }

                    $existing = DB::table('customer_receipts')->where('code', $group->receipt_code)->first();
                    if ($existing) {
                        $receiptId = $existing->id;
                    } else {
                        $subtotal = (float) $items->sum('total');
                        $receiptId = DB::table('customer_receipts')->insertGetId([
                            'customer_id' => $group->customer_id,
                            'order_id' => $group->order_id,
                            'code' => $group->receipt_code,
                            'subtotal' => $subtotal,
                            'discount' => 0,
                            'total' => $subtotal,
                            'paid_amount' => $subtotal,
                            'balance' => 0,
                            'payment_method' => 'cash',
                            'payment_status' => 'paid',
                            'sold_at' => $items->min('purchased_at'),
                            'notes' => $items->first()->notes,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                    }

                    DB::table('customer_purchases')
                        ->where('customer_id', $group->customer_id)
                        ->where('receipt_code', $group->receipt_code)
                        ->update(['customer_receipt_id' => $receiptId]);
                }
            });
    }
};
