<?php

namespace Tests\Feature;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class LocalizedSeoTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        config([
            'database.default' => 'seo_testing',
            'database.connections.seo_testing' => ['driver' => 'sqlite', 'database' => ':memory:', 'prefix' => ''],
        ]);
        DB::purge('seo_testing');
        Schema::connection('seo_testing')->create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug');
            $table->decimal('price', 10, 2)->default(0);
            $table->text('description')->nullable();
            $table->text('image_path')->nullable();
            $table->boolean('is_active')->default(true);
            $table->integer('stock')->nullable();
            $table->string('category');
            $table->string('subcategory')->nullable();
            $table->string('sku')->nullable();
            $table->string('barcode')->nullable();
            $table->json('sizes')->nullable();
            $table->timestamps();
        });
    }

    protected function tearDown(): void
    {
        Schema::connection('seo_testing')->dropIfExists('products');
        DB::purge('seo_testing');
        parent::tearDown();
    }

    public function test_category_has_self_canonical_and_all_language_alternates(): void
    {
        $response = $this->get('/mbulesa?lang=en')->assertOk();

        $response->assertSee('<html lang="en">', false)
            ->assertSee('Sofa &amp; Bed Covers Online in Kosovo', false)
            ->assertSee('rel="canonical" href="'.url('/mbulesa').'?lang=en"', false)
            ->assertSee('hreflang="sq"', false)
            ->assertSee('hreflang="en"', false)
            ->assertSee('hreflang="sr"', false)
            ->assertSee('hreflang="x-default"', false);
    }

    public function test_search_console_queries_are_used_on_their_relevant_categories(): void
    {
        $this->get('/perde')->assertOk()
            ->assertSee('Perde Kosovë', false)
            ->assertSee('Perde Moderne për Sallon', false);

        $this->get('/tepiha')->assertOk()
            ->assertSee('Tepiha Kosovë', false)
            ->assertSee('Tepiha për Sallon', false);

        $this->get('/garnishte')->assertOk()
            ->assertSee('Shtaga dhe Mbajtëse për Perde', false);
    }

    public function test_sitemap_contains_language_variants_and_excludes_private_flow_pages(): void
    {
        $response = $this->get('/sitemap.xml')->assertOk();

        $response->assertSee(url('/mbulesa').'?lang=en', false)
            ->assertSee('hreflang="sr"', false)
            ->assertDontSee('<loc>'.url('/checkout').'</loc>', false)
            ->assertDontSee('<loc>'.url('/cart').'</loc>', false)
            ->assertDontSee('<loc>'.url('/track').'</loc>', false);
    }

    public function test_old_generated_product_slug_redirects_to_unique_current_product(): void
    {
        DB::connection('seo_testing')->table('products')->insert([
            'name' => 'Tepih Side',
            'slug' => 'tepih-side',
            'price' => 45,
            'is_active' => 1,
            'category' => 'tepiha',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $this->get('/products/shkallore-side-0VGEe0')
            ->assertStatus(301)
            ->assertRedirect(route('products.show', 'tepih-side'));
    }

    public function test_removed_product_without_a_real_replacement_stays_404(): void
    {
        $this->get('/products/tepih-mara')->assertNotFound();
    }

    public function test_product_has_server_rendered_english_and_serbian_seo(): void
    {
        DB::connection('seo_testing')->table('products')->insert([
            'name' => 'GARNISHTE PLASTIK',
            'slug' => 'garnishte-plastik',
            'price' => 2,
            'description' => 'Garnishte plastike për perde.',
            'is_active' => 1,
            'category' => 'garnishte',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $base = url('/products/garnishte-plastik');
        $this->get('/products/garnishte-plastik?lang=en')->assertOk()
            ->assertSee('<html lang="en">', false)
            ->assertSee('Plastic Curtain Rail', false)
            ->assertSee('rel="canonical" href="'.$base.'?lang=en"', false)
            ->assertSee('hreflang="sr" href="'.$base.'?lang=sr"', false);

        $this->get('/products/garnishte-plastik?lang=sr')->assertOk()
            ->assertSee('<html lang="sr">', false)
            ->assertSee('Plastična Garnišna', false)
            ->assertSee('dostavom širom Kosova', false);
    }

    public function test_product_sitemap_contains_all_language_versions(): void
    {
        DB::connection('seo_testing')->table('products')->insert([
            'name' => 'GARNISHTE PLASTIK', 'slug' => 'garnishte-plastik', 'price' => 2,
            'is_active' => 1, 'category' => 'garnishte', 'created_at' => now(), 'updated_at' => now(),
        ]);

        $this->get('/sitemap-products.xml')->assertOk()
            ->assertSee(url('/products/garnishte-plastik').'?lang=en', false)
            ->assertSee(url('/products/garnishte-plastik').'?lang=sr', false)
            ->assertSee('hreflang="x-default"', false);
    }
}
