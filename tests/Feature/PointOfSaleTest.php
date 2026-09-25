<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\CustomerReceipt;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class PointOfSaleTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        config([
            'database.default' => 'pos_testing',
            'database.connections.pos_testing' => ['driver' => 'sqlite', 'database' => ':memory:', 'prefix' => ''],
        ]);
        DB::purge('pos_testing');
        $this->withoutMiddleware();

        Schema::create('products', function (Blueprint $table) {
            $table->id(); $table->string('name'); $table->string('slug')->unique();
            $table->decimal('price', 10, 2); $table->integer('stock')->default(0);
            $table->string('sku')->nullable(); $table->string('barcode')->nullable();
            $table->json('sizes')->nullable(); $table->string('image_path')->nullable();
            $table->boolean('is_active')->default(true); $table->timestamps();
        });
        Schema::create('customers', function (Blueprint $table) {
            $table->id(); $table->string('name'); $table->string('phone')->nullable();
            $table->string('email')->nullable(); $table->string('address')->nullable();
            $table->string('city')->nullable(); $table->timestamp('last_purchase_at')->nullable(); $table->timestamps();
        });
        Schema::create('customer_receipts', function (Blueprint $table) {
            $table->id(); $table->foreignId('customer_id'); $table->string('code');
            $table->string('receipt_type'); $table->string('source');
            $table->decimal('subtotal', 10, 2); $table->decimal('discount', 10, 2);
            $table->decimal('total', 10, 2); $table->decimal('paid_amount', 10, 2);
            $table->decimal('balance', 10, 2); $table->string('payment_method');
            $table->string('payment_status'); $table->timestamp('sold_at')->nullable();
            $table->text('notes')->nullable(); $table->timestamps();
        });
        Schema::create('customer_purchases', function (Blueprint $table) {
            $table->id(); $table->foreignId('customer_id'); $table->unsignedBigInteger('customer_receipt_id');
            $table->string('receipt_code'); $table->unsignedBigInteger('product_id')->nullable();
            $table->string('item_name'); $table->string('size')->nullable();
            $table->integer('quantity'); $table->decimal('unit_price', 10, 2);
            $table->decimal('total', 10, 2); $table->timestamp('purchased_at')->nullable();
            $table->text('notes')->nullable(); $table->timestamps();
        });
    }

    protected function tearDown(): void
    {
        foreach (['customer_purchases', 'customer_receipts', 'customers', 'products'] as $table) {
            Schema::dropIfExists($table);
        }
        DB::purge('pos_testing');
        parent::tearDown();
    }

    public function test_variant_barcode_lookup_returns_its_own_stock_and_price(): void
    {
        $product = $this->product();

        $this->getJson(route('admin.pos.lookup', ['q' => '2000000000012']))
            ->assertOk()->assertJsonPath('product.id', $product->id)
            ->assertJsonPath('product.selected_size.label', '200x300')
            ->assertJsonPath('product.selected_size.stock', 2)
            ->assertJsonPath('product.selected_size.price', 75);
    }

    public function test_empty_checkout_has_a_clear_albanian_message(): void
    {
        $this->post(route('admin.pos.checkout'), [
            'receipt_type' => 'regular',
            'payment_method' => 'cash',
        ])->assertSessionHasErrors([
            'items' => 'Shto të paktën një produkt në shportë para se ta ruash shitjen.',
        ]);
    }

    public function test_checkout_rejects_more_than_variant_stock_without_creating_receipt(): void
    {
        $product = $this->product();
        $this->post(route('admin.pos.checkout'), $this->checkoutData($product, 3))
            ->assertSessionHasErrors('items');

        $this->assertSame(0, DB::table('customer_receipts')->count());
        $this->assertSame(2, Product::find($product->id)->sizes[0]['stock']);
    }

    public function test_checkout_decrements_variant_stock_and_opens_printable_receipt(): void
    {
        $product = $this->product();
        $this->post(route('admin.pos.checkout'), $this->checkoutData($product, 1))
            ->assertRedirect();

        $receipt = DB::table('customer_receipts')->first();
        $this->assertNotNull($receipt);
        $this->assertSame(1, Product::find($product->id)->sizes[0]['stock']);
        $html = view('admin.pos.receipt', [
            'receipt' => CustomerReceipt::findOrFail($receipt->id)->load(['customer', 'purchases']),
        ])->render();
        $this->assertStringContainsString('DOKUMENT SHITJEJE', $html);
        $this->assertStringContainsString('Jo kupon fiskal zyrtar', $html);
    }

    private function product(): Product
    {
        return Product::create([
            'name' => 'Tepih Test', 'slug' => 'tepih-test', 'price' => 60,
            'stock' => 2, 'sku' => 'RUG-TEST', 'barcode' => 'BRL-TEST',
            'is_active' => true,
            'sizes' => [['label' => '200x300', 'price' => 75, 'stock' => 2, 'barcode' => '2000000000012']],
        ]);
    }

    private function checkoutData(Product $product, int $quantity): array
    {
        return [
            'receipt_type' => 'regular', 'payment_method' => 'cash', 'print_format' => 'receipt',
            'items' => [[
                'product_id' => $product->id, 'item_name' => $product->name,
                'size' => '200x300', 'quantity' => $quantity, 'unit_price' => 75,
            ]],
        ];
    }
}
