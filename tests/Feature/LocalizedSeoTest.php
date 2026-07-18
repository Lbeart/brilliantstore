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

    public function test_sitemap_contains_language_variants_and_excludes_private_flow_pages(): void
    {
        $response = $this->get('/sitemap.xml')->assertOk();

        $response->assertSee(url('/mbulesa').'?lang=en', false)
            ->assertSee('hreflang="sr"', false)
            ->assertDontSee('<loc>'.url('/checkout').'</loc>', false)
            ->assertDontSee('<loc>'.url('/cart').'</loc>', false)
            ->assertDontSee('<loc>'.url('/track').'</loc>', false);
    }
}
