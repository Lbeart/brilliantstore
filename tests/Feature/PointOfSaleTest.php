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
        view()->share('errors', new \Illuminate\Support\ViewErrorBag());

        Schema::create('products', function (Blueprint $table) {
            $table->id(); $table->string('name'); $table->string('slug')->unique();
            $table->decimal('price', 10, 2); $table->integer('stock')->default(0);
            $table->string('sku')->nullable(); $table->string('barcode')->nullable();
            $table->string('category')->nullable(); $table->string('subcategory')->nullable();
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

    public function test_pos_page_renders_working_scanner_cart_and_payment_hooks(): void
    {
        $this->product();

        $this->get(route('admin.pos.index'))
            ->assertOk()
            ->assertSee('data-scan-input', false)
            ->assertSee('data-scan-button', false)
            ->assertSee('data-quick-product', false)
            ->assertSee('data-pay-full', false)
            ->assertSee('const placeholderImage =', false)
            ->assertDontSee('this.src=\\\\\'', false);
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
        $receiptModel = CustomerReceipt::findOrFail($receipt->id)->load(['customer', 'purchases']);
        $html = view('admin.pos.receipt', ['receipt' => $receiptModel])->render();
        $this->assertStringContainsString('DOKUMENT SHITJEJE', $html);
        $this->assertStringContainsString('Jo kupon fiskal zyrtar', $html);
        $this->assertStringContainsString('function prepareReceiptPage()', $html);
        $this->assertStringContainsString("pageStyle.textContent = '@page{size:50mm '", $html);
        $this->assertStringContainsString('js/qz-tray.js?v=2.3.0', $html);
        $this->assertStringContainsString('data-qz-print', $html);
        $this->assertStringContainsString('function buildPixelReceipt()', $html);
        $this->assertStringContainsString("type: 'pixel'", $html);
        $this->assertStringContainsString("format: 'html'", $html);
        $this->assertStringContainsString('rasterize: true', $html);
        $this->assertStringContainsString('QZ_PAPER_HEIGHT_MM = 200', $html);
        $this->assertStringContainsString('custom: false', $html);
        $this->assertStringContainsString('qz.websocket.connect', $html);
        $this->assertStringContainsString('qz.printers.find', $html);
        $this->assertStringContainsString('Letra ndalet menjëherë pas faturës.', $html);
        $this->assertStringContainsString('body>*:not(.paper){display:none!important}', $html);
        $this->assertStringContainsString('data-estimated-page-height="145"', $html);

        foreach (range(2, 4) as $index) {
            $receiptModel->purchases()->create([
                'customer_id' => $receiptModel->customer_id,
                'receipt_code' => $receiptModel->code,
                'item_name' => 'Produkt Test '.$index,
                'size' => '200x300',
                'quantity' => 1,
                'unit_price' => 10,
                'total' => 10,
                'purchased_at' => now(),
            ]);
        }

        $multipleItemsHtml = view('admin.pos.receipt', [
            'receipt' => $receiptModel->fresh()->load(['customer', 'purchases']),
        ])->render();
        $this->assertStringContainsString('data-estimated-page-height="199"', $multipleItemsHtml);
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
