<?php

namespace Tests\Feature;

use App\Http\Middleware\AutoTranslateHtml;
use Illuminate\Http\Request;
use Tests\TestCase;

class AutoTranslateHtmlTest extends TestCase
{
    public function test_it_does_not_inject_translation_markup_into_admin_receipts(): void
    {
        $html = '<html><body><script>const receipt = "</body></html>";</script></body></html>';
        $request = Request::create('/admin/pos/receipts/84');

        $response = app(AutoTranslateHtml::class)->handle(
            $request,
            fn () => response($html, 200, ['Content-Type' => 'text/html'])
        );

        $this->assertSame($html, $response->getContent());
        $this->assertStringNotContainsString('google_translate_element', $response->getContent());
    }

    public function test_it_injects_before_the_final_body_tag_not_a_javascript_string(): void
    {
        $html = '<html><body><script>const receipt = "</body></html>";</script><main>Faqja</main></body></html>';
        $request = Request::create('/products');

        $response = app(AutoTranslateHtml::class)->handle(
            $request,
            fn () => response($html, 200, ['Content-Type' => 'text/html'])
        );
        $result = $response->getContent();

        $this->assertStringContainsString('const receipt = "</body></html>";</script>', $result);
        $this->assertGreaterThan(strpos($result, '</script><main>Faqja</main>'), strpos($result, 'google_translate_element'));
        $this->assertStringEndsWith('</body></html>', $result);
    }
}
