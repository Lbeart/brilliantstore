<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class AdminAssistantTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        config([
            'database.default' => 'admin_assistant_testing',
            'database.connections.admin_assistant_testing' => [
                'driver' => 'sqlite',
                'database' => ':memory:',
                'prefix' => '',
                'foreign_key_constraints' => true,
            ],
            'services.openai.key' => null,
        ]);

        DB::purge('admin_assistant_testing');
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('role')->default('user');
            $table->rememberToken();
            $table->timestamps();
        });
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->decimal('price', 10, 2)->default(0);
            $table->boolean('is_active')->default(true);
            $table->integer('stock')->nullable();
            $table->string('category')->nullable();
            $table->timestamps();
        });
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('phone');
            $table->string('email')->nullable();
            $table->string('address');
            $table->string('city')->nullable();
            $table->string('zip')->nullable();
            $table->text('notes')->nullable();
            $table->string('payment')->default('cash');
            $table->decimal('total', 10, 2)->default(0);
            $table->string('status')->default('new');
            $table->string('tracking_code')->nullable();
            $table->timestamps();
        });
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->cascadeOnDelete();
            $table->foreignId('product_id')->nullable();
            $table->string('name');
            $table->string('size')->nullable();
            $table->string('color')->nullable();
            $table->unsignedInteger('qty')->default(1);
            $table->decimal('price', 10, 2)->default(0);
            $table->string('image')->nullable();
            $table->timestamps();
        });
    }

    protected function tearDown(): void
    {
        Schema::dropIfExists('order_items');
        Schema::dropIfExists('orders');
        Schema::dropIfExists('products');
        Schema::dropIfExists('users');
        DB::purge('admin_assistant_testing');
        parent::tearDown();
    }

    public function test_only_an_admin_can_use_the_assistant(): void
    {
        $user = User::create([
            'name' => 'Customer',
            'email' => 'customer@example.com',
            'password' => bcrypt('password'),
            'role' => 'user',
        ]);
        $user->forceFill(['email_verified_at' => now()])->save();

        $this->actingAs($user)->postJson(route('admin.assistant.message'), [
            'message' => 'Sa porosi kemi?',
        ])->assertForbidden();
    }

    public function test_admin_receives_live_order_statistics_without_ai(): void
    {
        $this->actingAsAdmin();
        $this->order(['status' => 'new', 'total' => 45]);
        $this->order(['status' => 'processing', 'total' => 20]);

        $this->postJson(route('admin.assistant.message'), [
            'message' => 'A ka porosi te reja?',
        ])->assertOk()
            ->assertJsonPath('ai', false)
            ->assertJsonPath('reply', fn (string $reply) => str_contains($reply, '1'));
    }

    public function test_admin_can_ask_for_a_specific_order_and_its_items(): void
    {
        $this->actingAsAdmin();
        $order = $this->order(['tracking_code' => 'BRL-AB12-CD34', 'total' => 34]);
        $order->items()->create([
            'name' => 'Batanije Rodos',
            'size' => '200x220',
            'color' => 'Cream',
            'qty' => 2,
            'price' => 17,
        ]);

        $this->postJson(route('admin.assistant.message'), [
            'message' => 'Me trego porosine #'.$order->id,
        ])->assertOk()
            ->assertJsonPath('reply', fn (string $reply) => str_contains($reply, 'Batanije Rodos') && str_contains($reply, 'Cream'));
    }

    private function actingAsAdmin(): User
    {
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);
        $admin->forceFill(['email_verified_at' => now()])->save();
        $this->actingAs($admin);

        return $admin;
    }

    private function order(array $overrides = []): Order
    {
        return Order::create(array_merge([
            'name' => 'Test Customer',
            'phone' => '044000000',
            'email' => 'buyer@example.com',
            'address' => 'Lipjan',
            'city' => 'Lipjan',
            'zip' => '14000',
            'payment' => 'cash',
            'total' => 10,
            'status' => 'new',
        ], $overrides));
    }
}
