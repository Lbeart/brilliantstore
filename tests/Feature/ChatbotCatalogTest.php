<?php

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class ChatbotCatalogTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        config([
            'database.default' => 'chatbot_testing',
            'database.connections.chatbot_testing' => [
                'driver' => 'sqlite',
                'database' => ':memory:',
                'prefix' => '',
                'foreign_key_constraints' => true,
            ],
            'services.openai.key' => null,
        ]);

        DB::purge('chatbot_testing');
        Schema::connection('chatbot_testing')->create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->decimal('price', 10, 2)->default(0);
            $table->json('sizes')->nullable();
            $table->json('color_variants')->nullable();
            $table->integer('stock')->nullable();
            $table->text('image_path')->nullable();
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->string('category', 50)->index();
            $table->string('subcategory')->nullable();
            $table->string('sku')->nullable()->unique();
            $table->string('barcode')->nullable()->unique();
            $table->timestamps();
        });
        Schema::connection('chatbot_testing')->create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('tracking_code')->nullable();
            $table->string('status')->default('new');
            $table->string('payment')->nullable();
            $table->decimal('total', 10, 2)->default(0);
            $table->timestamps();
        });
        Schema::connection('chatbot_testing')->create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->cascadeOnDelete();
            $table->foreignId('product_id')->nullable();
            $table->string('name');
            $table->text('size')->nullable();
            $table->string('color')->nullable();
            $table->integer('qty')->default(1);
            $table->decimal('price', 10, 2)->default(0);
            $table->text('image')->nullable();
            $table->timestamps();
        });
    }

    protected function tearDown(): void
    {
        Schema::connection('chatbot_testing')->dropIfExists('order_items');
        Schema::connection('chatbot_testing')->dropIfExists('orders');
        Schema::connection('chatbot_testing')->dropIfExists('products');
        DB::purge('chatbot_testing');

        parent::tearDown();
    }

    public function test_greeting_does_not_show_random_products(): void
    {
        $this->product(['name' => 'Tepih Nova', 'category' => 'tepiha']);

        $this->postJson(route('chatbot.message'), ['message' => 'Përshëndetje bro 👋'])
            ->assertOk()
            ->assertJsonCount(0, 'products');
    }

    public function test_bath_rug_intent_is_more_specific_than_general_rugs(): void
    {
        $this->product(['name' => 'Tepih Nova', 'category' => 'tepiha']);
        $bath = $this->product(['name' => 'Set Banjo Soft', 'category' => 'tepihebanjo']);
        $this->product(['name' => 'Set Banjo Joaktiv', 'category' => 'tepihebanjo', 'is_active' => false]);

        $response = $this->postJson(route('chatbot.message'), ['message' => 'A keni tepih banjo?'])
            ->assertOk()
            ->assertJsonPath('action.url', route('products.tepihebanjo', [], false))
            ->assertJsonCount(1, 'products');

        $this->assertSame($bath->id, $response->json('products.0.id'));
    }

    public function test_curtain_intent_respects_subcategory(): void
    {
        $side = $this->product(['name' => 'Perde Elegance', 'category' => 'perde', 'subcategory' => 'anesore']);
        $this->product(['name' => 'Perde Drita', 'category' => 'perde', 'subcategory' => 'ditore']);

        $response = $this->postJson(route('chatbot.message'), ['message' => 'Më gjej perde anësore'])
            ->assertOk()
            ->assertJsonCount(1, 'products');

        $this->assertSame($side->id, $response->json('products.0.id'));
    }

    public function test_unknown_color_and_size_never_fall_back_to_unrelated_products(): void
    {
        $this->product([
            'name' => 'Tepih Otto 1010',
            'category' => 'tepiha',
            'sizes' => [['label' => '300x200', 'price' => 95, 'stock' => 2]],
            'color_variants' => [['name' => 'Hiri', 'hex' => '#777777']],
        ]);

        Http::fake();
        $this->postJson(route('chatbot.message'), ['message' => 'A keni tepih të kuq 160x230?'])
            ->assertOk()
            ->assertJsonPath('ai', false)
            ->assertJsonCount(0, 'products')
            ->assertJsonPath('reply', fn (string $reply) => str_contains($reply, 'nuk figuron aktualisht'));
        Http::assertNothingSent();
    }

    public function test_follow_up_uses_previous_category_and_matches_reversed_dimensions(): void
    {
        $rug = $this->product([
            'name' => 'Tepih Otto 1010',
            'category' => 'tepiha',
            'sizes' => [['label' => '300x200', 'price' => 95, 'stock' => 2]],
            'color_variants' => [['name' => 'Hiri', 'hex' => '#777777']],
        ]);
        $this->product([
            'name' => 'Batanije Hiri',
            'category' => 'batanije',
            'sizes' => [['label' => '200x300', 'price' => 25, 'stock' => 3]],
            'color_variants' => [['name' => 'Grey', 'hex' => '#777777']],
        ]);

        $response = $this->postJson(route('chatbot.message'), [
            'message' => 'Po në ngjyrë hiri 200x300?',
            'history' => [
                ['role' => 'user', 'content' => 'A keni tepih?'],
                ['role' => 'assistant', 'content' => 'Po, shiko modelet më poshtë.'],
            ],
        ])->assertOk()->assertJsonCount(1, 'products');

        $this->assertSame($rug->id, $response->json('products.0.id'));
        $this->assertSame('300x200', $response->json('products.0.matched_size.label'));
    }

    public function test_cards_use_size_price_range_colors_and_stock_metadata(): void
    {
        $this->product([
            'name' => 'Batanije Rodos',
            'category' => 'batanije',
            'price' => 15,
            'sizes' => [
                ['label' => '150x200', 'price' => 15, 'stock' => 3],
                ['label' => '200x220', 'price' => 17, 'stock' => 1],
            ],
            'color_variants' => [['name' => 'Beige', 'hex' => '#d8c3a5']],
        ]);

        $response = $this->postJson(route('chatbot.message'), ['message' => 'A keni batanije Rodos?'])
            ->assertOk()
            ->assertJsonPath('products.0.price_min', 15)
            ->assertJsonPath('products.0.price_max', 17)
            ->assertJsonPath('products.0.price_text', '15.00–17.00 €')
            ->assertJsonPath('products.0.stock_status', 'in_stock');

        $this->assertSame(['Beige'], $response->json('products.0.colors'));
    }

    public function test_blanket_for_two_people_understands_double_bed_dimensions(): void
    {
        $double = $this->product([
            'name' => 'Batanije Rodos Dopio',
            'category' => 'batanije',
            'sizes' => [['label' => '200x220', 'price' => 17, 'stock' => 3]],
        ]);
        $this->product([
            'name' => 'Batanije Rodos Teke',
            'category' => 'batanije',
            'sizes' => [['label' => '150x200', 'price' => 15, 'stock' => 3]],
        ]);

        $response = $this->postJson(route('chatbot.message'), ['message' => 'A keni batanije për ddy persona?'])
            ->assertOk()
            ->assertJsonCount(1, 'products')
            ->assertJsonPath('products.0.matched_size.label', '200x220')
            ->assertJsonPath('products.0.requested_size_confirmed', true);

        $this->assertSame($double->id, $response->json('products.0.id'));
    }

    public function test_bedsheets_for_one_or_two_people_match_their_real_category_sizes(): void
    {
        $set = $this->product([
            'name' => 'Set Qarqafësh Saten',
            'category' => 'postava',
            'sizes' => [
                ['label' => '240x260', 'price' => 20, 'stock' => 10],
                ['label' => '160x240', 'price' => 18, 'stock' => 4],
            ],
        ]);

        $double = $this->postJson(route('chatbot.message'), ['message' => 'A keni postava për dy persona?'])
            ->assertOk()
            ->assertJsonCount(1, 'products')
            ->assertJsonPath('products.0.matched_size.label', '240x260')
            ->assertJsonPath('products.0.requested_size_confirmed', true);

        $this->assertSame($set->id, $double->json('products.0.id'));

        $single = $this->postJson(route('chatbot.message'), ['message' => 'A keni postava për një person?'])
            ->assertOk()
            ->assertJsonCount(1, 'products')
            ->assertJsonPath('products.0.matched_size.label', '160x240')
            ->assertJsonPath('products.0.requested_size_confirmed', true);

        $this->assertSame($set->id, $single->json('products.0.id'));
    }

    public function test_follow_up_can_select_a_product_card_by_ordinal(): void
    {
        $first = $this->product(['name' => 'Tepih Nova', 'category' => 'tepiha']);
        $second = $this->product(['name' => 'Tepih Mara', 'category' => 'tepiha']);

        $response = $this->postJson(route('chatbot.message'), [
            'message' => 'Të dytin, sa kushton?',
            'history' => [
                ['role' => 'user', 'content' => 'Më trego disa tepiha'],
                ['role' => 'assistant', 'content' => 'Shiko kartat më poshtë.'],
            ],
            'context_product_ids' => [$first->id, $second->id],
        ])->assertOk()->assertJsonCount(1, 'products');

        $this->assertSame($second->id, $response->json('products.0.id'));
    }

    public function test_colloquial_meter_dimensions_match_catalog_sizes(): void
    {
        $rug = $this->product([
            'name' => 'Tepih Family',
            'category' => 'tepiha',
            'sizes' => [['label' => '300x400', 'price' => 120, 'stock' => 1]],
        ]);

        $rugResponse = $this->postJson(route('chatbot.message'), ['message' => 'A keni tepih 3 me 4?'])
            ->assertOk()->assertJsonCount(1, 'products');
        $this->assertSame($rug->id, $rugResponse->json('products.0.id'));

        $rail = $this->product([
            'name' => 'Garnishte Plastik',
            'category' => 'garnishte',
            'sizes' => [['label' => '6', 'price' => 24, 'stock' => 2]],
        ]);

        $railResponse = $this->postJson(route('chatbot.message'), ['message' => 'A keni garnishte 6 metra?'])
            ->assertOk()->assertJsonCount(1, 'products');
        $this->assertSame($rail->id, $railResponse->json('products.0.id'));
    }

    public function test_dimension_search_returns_every_matching_active_rug_not_only_the_first_five(): void
    {
        $matchingIds = [];

        foreach (range(1, 13) as $index) {
            $matchingIds[] = $this->product([
                'name' => 'Tepih Model '.$index,
                'category' => 'tepiha',
                'sizes' => [
                    ['label' => '150x230', 'price' => 60 + $index, 'stock' => 2],
                    ['label' => $index % 2 === 0 ? '200 x 300 cm' : '300x200', 'price' => 100 + $index, 'stock' => 3],
                ],
            ])->id;
        }

        $this->product([
            'name' => 'Tepih Pa Përputhje',
            'category' => 'tepiha',
            'sizes' => [['label' => '120x180', 'price' => 40, 'stock' => 3]],
        ]);

        $response = $this->postJson(route('chatbot.message'), ['message' => 'Mi trego të gjithë tepihat 300x200'])
            ->assertOk()
            ->assertJsonCount(13, 'products');

        $this->assertEqualsCanonicalizing($matchingIds, $response->json('products.*.id'));
        foreach ($response->json('products') as $product) {
            $this->assertSame('300x200', str_replace([' ', 'cm'], '', $product['matched_size']['label']) === '200x300'
                ? '300x200'
                : $product['matched_size']['label']);
            $this->assertTrue($product['requested_size_confirmed']);
        }
    }

    public function test_ai_reply_with_an_invented_price_is_rejected(): void
    {
        config(['services.openai.key' => 'test-key']);
        $this->product([
            'name' => 'Tepih Asya',
            'category' => 'tepiha',
            'sizes' => [['label' => '150x230', 'price' => 75, 'stock' => 2]],
        ]);

        Http::fake(['*' => Http::response([
            'output' => [[
                'type' => 'message',
                'content' => [['type' => 'output_text', 'text' => 'Tepih Asya kushton 10 €.']],
            ]],
        ], 200)]);

        $this->postJson(route('chatbot.message'), ['message' => 'Sa kushton Tepih Asya?'])
            ->assertOk()
            ->assertJsonPath('ai', false)
            ->assertJsonPath('products.0.price_text', '75.00 €')
            ->assertJsonPath('reply', fn (string $reply) => str_contains($reply, 'Tepih Asya'));
    }

    public function test_missing_product_is_explained_by_ai_without_claiming_it_is_sold(): void
    {
        config(['services.openai.key' => 'test-key']);
        $this->product(['name' => 'Tepih Hali 256', 'category' => 'tepiha']);

        Http::fake(['*' => Http::response([
            'output' => [[
                'type' => 'message',
                'content' => [[
                    'type' => 'output_text',
                    'text' => 'Laminati është një material praktik për dysheme. Nuk figuron në katalogun aktiv të B-Brillant; ne merremi kryesisht me tekstile për shtëpi.',
                ]],
            ]],
        ], 200)]);

        $this->postJson(route('chatbot.message'), ['message' => 'A keni laminat dhe çka është?'])
            ->assertOk()
            ->assertJsonPath('ai', true)
            ->assertJsonCount(0, 'products')
            ->assertJsonPath('reply', fn (string $reply) => str_contains($reply, 'Laminati') && str_contains($reply, 'Nuk figuron'));

        Http::assertSentCount(1);
    }

    public function test_general_customer_question_is_answered_by_ai_without_becoming_a_failed_catalog_search(): void
    {
        config(['services.openai.key' => 'test-key']);
        $this->product(['name' => 'Tepih Hali 256', 'category' => 'tepiha']);

        Http::fake(['*' => Http::response([
            'output' => [[
                'type' => 'message',
                'content' => [[
                    'type' => 'output_text',
                    'text' => 'Për një sallon të vogël, ngjyrat e çelëta dhe perdet deri në dysheme e bëjnë hapësirën të duket më e madhe.',
                ]],
            ]],
        ], 200)]);

        $this->postJson(route('chatbot.message'), [
            'message' => 'Si mund ta bëj sallonin e vogël të duket më i madh?',
        ])->assertOk()
            ->assertJsonPath('ai', true)
            ->assertJsonCount(0, 'products')
            ->assertJsonPath('reply', fn (string $reply) => str_contains($reply, 'ngjyrat e çelëta'));

        Http::assertSent(function ($request) {
            return str_contains((string) $request['instructions'], '"catalog_searched":false')
                && str_contains((string) $request['instructions'], '"no_exact_match":false')
                && str_contains((string) $request['instructions'], '"full_active_catalog"')
                && str_contains((string) $request['instructions'], 'Tepih Hali 256');
        });
    }

    public function test_advice_question_that_mentions_a_catalog_category_still_goes_to_ai(): void
    {
        config(['services.openai.key' => 'test-key']);
        $this->product(['name' => 'Tepih Hali 256', 'category' => 'tepiha']);

        Http::fake(['*' => Http::response([
            'output' => [[
                'type' => 'message',
                'content' => [['type' => 'output_text', 'text' => 'Pastroje tepihun me aspirim të rregullt dhe trajto njollat pa e fërkuar fort.']],
            ]],
        ], 200)]);

        $this->postJson(route('chatbot.message'), ['message' => 'Si pastrohet tepihu?'])
            ->assertOk()
            ->assertJsonPath('ai', true)
            ->assertJsonCount(0, 'products')
            ->assertJsonPath('reply', fn (string $reply) => str_contains($reply, 'Pastroje tepihun'));

        Http::assertSent(fn ($request) => str_contains((string) $request['instructions'], '"catalog_searched":false'));
    }

    public function test_general_ai_answer_may_contain_euros_without_being_rejected_as_a_fake_catalog_price(): void
    {
        config(['services.openai.key' => 'test-key']);

        Http::fake(['*' => Http::response([
            'output' => [[
                'type' => 'message',
                'content' => [['type' => 'output_text', 'text' => 'Një buxhet prej 100 € mund ta ndash sipas prioriteteve të tua.']],
            ]],
        ], 200)]);

        $this->postJson(route('chatbot.message'), ['message' => 'Si ta ndaj një buxhet prej njëqind eurosh?'])
            ->assertOk()
            ->assertJsonPath('ai', true)
            ->assertJsonPath('reply', fn (string $reply) => str_contains($reply, '100 €'));
    }

    public function test_ai_cannot_claim_that_a_missing_product_is_in_stock(): void
    {
        config(['services.openai.key' => 'test-key']);
        $this->product(['name' => 'Tepih Hali 256', 'category' => 'tepiha']);

        Http::fake(['*' => Http::response([
            'output' => [[
                'type' => 'message',
                'content' => [['type' => 'output_text', 'text' => 'Po, e kemi në stok dhe kushton 20 €.']],
            ]],
        ], 200)]);

        $this->postJson(route('chatbot.message'), ['message' => 'A keni laminat?'])
            ->assertOk()
            ->assertJsonPath('ai', false)
            ->assertJsonCount(0, 'products')
            ->assertJsonPath('reply', fn (string $reply) => str_contains($reply, 'nuk figuron aktualisht'));
    }

    public function test_chatbot_reads_the_current_session_cart(): void
    {
        $this->withSession([
            'cart' => [
                'product|1|150x230|' => [
                    'name' => 'Tepih Nova',
                    'qty' => 2,
                    'price' => 45,
                    'size' => '150x230',
                    'color' => null,
                ],
            ],
        ])->postJson(route('chatbot.message'), ['message' => 'Sa e kam totalin në shporta?'])
            ->assertOk()
            ->assertJsonPath('ai', false)
            ->assertJsonPath('action.url', route('cart.index', [], false))
            ->assertJsonPath('reply', fn (string $reply) => str_contains($reply, '2 artikuj') && str_contains($reply, '90.00 €'));
    }

    public function test_in_stock_request_excludes_unavailable_products(): void
    {
        $available = $this->product(['name' => 'Tepih Nova', 'category' => 'tepiha', 'stock' => 3]);
        $this->product(['name' => 'Tepih Mara', 'category' => 'tepiha', 'stock' => 0]);

        $response = $this->postJson(route('chatbot.message'), ['message' => 'Cilat tepiha i keni në stok?'])
            ->assertOk()->assertJsonCount(1, 'products');

        $this->assertSame($available->id, $response->json('products.0.id'));
    }

    public function test_follow_up_can_change_model_or_request_another_product(): void
    {
        $otto = $this->product(['name' => 'Tepih Otto', 'category' => 'tepiha']);
        $mara = $this->product(['name' => 'Tepih Mara', 'category' => 'tepiha']);
        $history = [
            ['role' => 'user', 'content' => 'A keni Tepih Otto?'],
            ['role' => 'assistant', 'content' => 'Po, shiko kartën më poshtë.'],
        ];

        $changed = $this->postJson(route('chatbot.message'), [
            'message' => 'Po Mara?',
            'history' => $history,
            'context_product_ids' => [$otto->id],
        ])->assertOk()->assertJsonCount(1, 'products');
        $this->assertSame($mara->id, $changed->json('products.0.id'));

        $another = $this->postJson(route('chatbot.message'), [
            'message' => 'Po një tjetër?',
            'history' => $history,
            'context_product_ids' => [$otto->id],
        ])->assertOk();
        $this->assertNotContains($otto->id, $another->json('products.*.id'));
    }

    public function test_kosovar_dialect_and_color_variants_are_understood(): void
    {
        $hali = $this->product([
            'name' => 'Tepih Hali 256',
            'category' => 'tepiha',
            'color_variants' => [['name' => 'White', 'hex' => '#ffffff']],
        ]);

        $response = $this->postJson(route('chatbot.message'), [
            'message' => 'A ka të bardha?',
            'history' => [
                ['role' => 'user', 'content' => 'Qfar ngjyra ka tepih Hali?'],
                ['role' => 'assistant', 'content' => 'Po e kontrolloj katalogun.'],
            ],
            'context_product_ids' => [$hali->id],
        ])->assertOk()->assertJsonCount(1, 'products');

        $this->assertSame($hali->id, $response->json('products.0.id'));
        $this->assertSame(['White'], $response->json('products.0.colors'));
    }

    public function test_location_question_does_not_inherit_previous_product_context(): void
    {
        $rug = $this->product(['name' => 'Tepih Hali 256', 'category' => 'tepiha']);

        $this->postJson(route('chatbot.message'), [
            'message' => 'Ku gjendeni?',
            'history' => [
                ['role' => 'user', 'content' => 'A keni tepih Hali?'],
                ['role' => 'assistant', 'content' => 'Po, shiko kartën poshtë.'],
            ],
            'context_product_ids' => [$rug->id],
        ])->assertOk()
            ->assertJsonCount(0, 'products')
            ->assertJsonPath('action.url', route('contact', [], false))
            ->assertJsonPath('reply', fn (string $reply) => str_contains($reply, 'Gjergj Fishta'));
    }

    public function test_tracking_code_is_looked_up_and_returns_real_order_status_without_personal_data(): void
    {
        $orderId = DB::connection('chatbot_testing')->table('orders')->insertGetId([
            'tracking_code' => 'BRL-AB12-CD34',
            'status' => 'processing',
            'payment' => 'cash',
            'total' => 34,
            'created_at' => '2026-07-17 10:30:00',
            'updated_at' => '2026-07-17 10:30:00',
        ]);
        DB::connection('chatbot_testing')->table('order_items')->insert([
            'order_id' => $orderId,
            'name' => 'Batanije Rodos',
            'size' => '200x220',
            'color' => 'Cream',
            'qty' => 2,
            'price' => 17,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $this->postJson(route('chatbot.message'), ['message' => 'BRL AB12 CD34'])
            ->assertOk()
            ->assertJsonPath('ai', false)
            ->assertJsonCount(0, 'products')
            ->assertJsonPath('action.url', route('track.show', 'BRL-AB12-CD34', false))
            ->assertJsonPath('reply', fn (string $reply) => str_contains($reply, 'Në procesim')
                && str_contains($reply, '17.07.2026 10:30')
                && str_contains($reply, 'Batanije Rodos')
                && str_contains($reply, '200x220')
                && str_contains($reply, 'Cream')
                && str_contains($reply, '34.00'));
    }

    public function test_unknown_tracking_code_is_reported_as_not_found(): void
    {
        $this->postJson(route('chatbot.message'), ['message' => 'Ku është porosia BRL-ZZZZ-9999?'])
            ->assertOk()
            ->assertJsonPath('ai', false)
            ->assertJsonPath('reply', fn (string $reply) => str_contains($reply, 'Nuk gjeta porosi'));
    }

    public function test_misspelled_dialect_location_question_does_not_become_a_product_search(): void
    {
        $rug = $this->product(['name' => 'Tepih Hali 256', 'category' => 'tepiha']);

        foreach (['ku gjindeni', 'Ku gjindet lokali?', 'ku e keni dyqanin'] as $question) {
            $this->postJson(route('chatbot.message'), [
                'message' => $question,
                'history' => [
                    ['role' => 'user', 'content' => 'A keni tepih Hali?'],
                    ['role' => 'assistant', 'content' => 'Po, shiko kartën poshtë.'],
                ],
                'context_product_ids' => [$rug->id],
            ])->assertOk()
                ->assertJsonCount(0, 'products')
                ->assertJsonPath('action.url', route('contact', [], false))
                ->assertJsonPath('reply', fn (string $reply) => str_contains($reply, 'Gjergj Fishta'));
        }
    }

    public function test_colloquial_this_product_phrase_does_not_block_exact_match(): void
    {
        $otto = $this->product([
            'name' => 'Tepih Otto 1010',
            'category' => 'tepiha',
            'color_variants' => [['name' => 'Cream', 'hex' => '#f5ead7']],
        ]);

        $response = $this->postJson(route('chatbot.message'), [
            'message' => 'Qikjo 1010 Cream Otto a ka?',
            'history' => [
                ['role' => 'user', 'content' => 'Më trego tepiha 300x200'],
                ['role' => 'assistant', 'content' => 'Shiko kartat poshtë.'],
            ],
            'context_product_ids' => [$otto->id],
        ])->assertOk()->assertJsonCount(1, 'products');

        $this->assertSame($otto->id, $response->json('products.0.id'));
    }

    public function test_known_model_without_structured_sizes_is_returned_for_confirmation(): void
    {
        $hali = $this->product([
            'name' => 'Tepih Hali 256',
            'category' => 'tepiha',
            'price' => 75,
            'sizes' => [],
        ]);
        $this->product([
            'name' => 'Tepih Nova',
            'category' => 'tepiha',
            'sizes' => [['label' => '300x200', 'price' => 105, 'stock' => 2]],
        ]);

        $response = $this->postJson(route('chatbot.message'), ['message' => 'Hali 300x200'])
            ->assertOk()
            ->assertJsonCount(1, 'products')
            ->assertJsonPath('products.0.requested_size', '300x200')
            ->assertJsonPath('products.0.requested_size_confirmed', false)
            ->assertJsonPath('products.0.stock_status', 'confirm')
            ->assertJsonPath('products.0.stock_label', 'Konfirmo përmasën 300x200');

        $this->assertSame($hali->id, $response->json('products.0.id'));
    }

    public function test_dimensions_written_only_in_description_can_find_the_named_product(): void
    {
        $hali = $this->product([
            'name' => 'Tepih Hali 256',
            'category' => 'tepiha',
            'description' => 'Modeli ofrohet 200×300 cm.',
            'sizes' => [],
        ]);

        $response = $this->postJson(route('chatbot.message'), ['message' => 'Hali 300x200'])
            ->assertOk()->assertJsonCount(1, 'products');

        $this->assertSame($hali->id, $response->json('products.0.id'));
        $this->assertFalse($response->json('products.0.requested_size_confirmed'));
    }

    private function product(array $attributes): Product
    {
        static $counter = 0;
        $counter++;

        return Product::query()->create(array_merge([
            'name' => 'Produkt '.$counter,
            'slug' => 'produkt-'.$counter,
            'price' => 20,
            'description' => null,
            'image_path' => null,
            'is_active' => true,
            'stock' => 5,
            'category' => 'tepiha',
            'subcategory' => null,
            'sizes' => [],
            'color_variants' => [],
            'sku' => 'SKU-'.$counter,
            'barcode' => 'BRL'.$counter,
        ], $attributes));
    }
}
