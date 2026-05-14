<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class AutoTranslateHtml
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        if (! method_exists($response, 'getContent') || ! method_exists($response, 'setContent')) {
            return $response;
        }

        $contentType = (string) $response->headers->get('Content-Type', '');
        $html = (string) $response->getContent();

        if (
            stripos($contentType, 'text/html') === false ||
            stripos($html, '</body>') === false
        ) {
            return $response;
        }

        $locale = App::getLocale();
        if (! in_array($locale, ['sq', 'en', 'sr'], true)) {
            $locale = 'sq';
        }

        $script = $this->translationScript($locale);
        $html = preg_replace('/<\/body>/i', $script . "\n</body>", $html, 1);

        $response->setContent($html);

        return $response;
    }

    private function translationScript(string $locale): string
    {
        $target = json_encode($locale, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT);

        return <<<HTML
<div id="google_translate_element" style="position:absolute;left:-9999px;top:-9999px;width:1px;height:1px;overflow:hidden;"></div>
<style>
  .goog-te-banner-frame,
  .goog-te-balloon-frame,
  .goog-te-gadget-icon,
  .goog-logo-link { display: none !important; }
  body { top: 0 !important; }
  #goog-gt-tt { display: none !important; }
</style>
<script>
(function () {
  var target = {$target};
  var source = 'sq';
  var cookieName = 'googtrans';

  function setCookie(name, value, days) {
    var expires = '';
    if (days) {
      var date = new Date();
      date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
      expires = '; expires=' + date.toUTCString();
    }
    document.cookie = name + '=' + value + expires + '; path=/; SameSite=Lax';
    document.cookie = name + '=' + value + expires + '; path=/; domain=' + location.hostname + '; SameSite=Lax';
  }

  function clearCookie(name) {
    setCookie(name, '', -1);
  }

  if (target === source) {
    clearCookie(cookieName);
    return;
  }

  setCookie(cookieName, '/' + source + '/' + target, 7);

  window.googleTranslateElementInit = function () {
    new google.translate.TranslateElement({
      pageLanguage: source,
      includedLanguages: 'en,sr,sq',
      autoDisplay: false
    }, 'google_translate_element');
  };

  if (!document.querySelector('script[data-brillant-translate]')) {
    var script = document.createElement('script');
    script.src = 'https://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit';
    script.async = true;
    script.setAttribute('data-brillant-translate', '1');
    document.head.appendChild(script);
  }
})();
</script>
HTML;
    }
}
