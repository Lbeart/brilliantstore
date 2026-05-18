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
            Schema::create('customer_purchases', function (Blueprint $table) {
                $table->id();
                $table->foreignId('customer_id')->constrained()->cascadeOnDelete();
                $table->foreignId('order_id')->nullable()->constrained()->nullOnDelete();
                $table->unsignedBigInteger('product_id')->nullable();
                $table->string('receipt_code', 40)->nullable()->index();
                $table->string('item_name');
                $table->string('size')->nullable();
                $table->unsignedInteger('quantity')->default(1);
                $table->decimal('unit_price', 10, 2)->default(0);
                $table->decimal('total', 10, 2)->default(0);
                $table->timestamp('purchased_at')->nullable();
                $table->text('notes')->nullable();
                $table->timestamps();

                $table->index(['item_name', 'purchased_at']);
            });
        }

        $this->backfillFromOrders();
    }

    public function down(): void
    {
        Schema::dropIfExists('customer_purchases');
    }

    private function backfillFromOrders(): void
    {
        if (!Schema::hasTable('orders') || !Schema::hasTable('order_items') || !Schema::hasTable('customers')) {
            return;
        }

        DB::table('orders')->orderBy('id')->chunkById(100, function ($orders) {
            foreach ($orders as $order) {
                $customer = DB::table('customers')
                    ->when(!empty($order->phone), fn ($q) => $q->orWhere('phone', $order->phone))
                    ->when(!empty($order->email), fn ($q) => $q->orWhere('email', $order->email))
                    ->first();

                if (!$customer) {
                    $customerId = DB::table('customers')->insertGetId([
                        'name' => $order->name,
                        'phone' => $order->phone,
                        'email' => $order->email,
                        'address' => $order->address,
                        'city' => $order->city,
                        'last_purchase_at' => $order->created_at,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                } else {
                    $customerId = $customer->id;
                    DB::table('customers')->where('id', $customerId)->update([
                        'name' => $customer->name ?: $order->name,
                        'phone' => $customer->phone ?: $order->phone,
                        'email' => $customer->email ?: $order->email,
                        'address' => $customer->address ?: $order->address,
                        'city' => $customer->city ?: $order->city,
                        'last_purchase_at' => $order->created_at,
                        'updated_at' => now(),
                    ]);
                }

                if (Schema::hasColumn('orders', 'customer_id')) {
                    DB::table('orders')->where('id', $order->id)->update(['customer_id' => $customerId]);
                }

                $items = DB::table('order_items')->where('order_id', $order->id)->get();
                foreach ($items as $item) {
                    DB::table('customer_purchases')->insert([
                        'customer_id' => $customerId,
                        'order_id' => $order->id,
                        'product_id' => $item->product_id,
                        'receipt_code' => 'ORD-'.$order->id,
                        'item_name' => $item->name,
                        'size' => $item->size,
                        'quantity' => $item->qty,
                        'unit_price' => $item->price,
                        'total' => ((int) $item->qty) * ((float) $item->price),
                        'purchased_at' => $order->created_at,
                        'notes' => $order->notes,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        });
    }
};
