<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class LocalizedSeoMeta
{
    private const CATEGORIES = [
        'products.perde' => ['path' => '/perde', 'sq' => ['Perde Online në Kosovë | Brillant Lipjan', 'Perde moderne për sallon, dhomë gjumi dhe zyrë me matje, qepje, montim dhe dërgesë në gjithë Kosovën nga B-Brillant Lipjan.'], 'en' => ['Curtains Online in Kosovo | B-Brillant Lipjan', 'Modern curtains for living rooms, bedrooms and offices, with measuring, sewing, installation and delivery throughout Kosovo.'], 'sr' => ['Zavese Online na Kosovu | B-Brillant Lipljan', 'Moderne zavese za dnevnu sobu, spavaću sobu i kancelariju, sa merenjem, šivenjem, montažom i dostavom širom Kosova.']],
        'products.perdeDitore' => ['path' => '/perde-ditore', 'sq' => ['Perde Ditore Online | Matje dhe Montim në Kosovë', 'Perde ditore, perde të tejdukshme, bamboo dhe kumaş për shtëpi me matje, qepje, montim dhe dërgesë në Kosovë.'], 'en' => ['Sheer & Day Curtains Online in Kosovo | B-Brillant', 'Shop sheer and day curtains for homes, including measuring, custom sewing, installation and delivery throughout Kosovo.'], 'sr' => ['Dnevne i Prozračne Zavese Online | B-Brillant', 'Dnevne, prozračne i bambus zavese za dom sa merenjem, šivenjem, montažom i dostavom širom Kosova.']],
        'products.anesore' => ['path' => '/anesore', 'sq' => ['Perde Anësore Moderne në Kosovë | B-Brillant', 'Perde anësore moderne dhe klasike për sallon e dhomë gjumi, me qepje profesionale, matje dhe montim në Kosovë.'], 'en' => ['Modern Side Curtains in Kosovo | B-Brillant', 'Modern and classic side curtains for living rooms and bedrooms, with professional sewing, measuring and installation in Kosovo.'], 'sr' => ['Moderne Bočne Zavese na Kosovu | B-Brillant', 'Moderne i klasične bočne zavese za dnevnu i spavaću sobu, sa profesionalnim šivenjem, merenjem i montažom.']],
        'products.mbulesa' => ['path' => '/mbulesa', 'sq' => ['Mbulesa Online në Kosovë | Divan, Krevat & Kolltuk', 'Mbulesa moderne për divan, kolltuk, krevat dhe sallon. Modele cilësore me përmasa e ngjyra të ndryshme dhe dërgesë në Kosovë.'], 'en' => ['Sofa & Bed Covers Online in Kosovo | B-Brillant', 'Modern covers for sofas, armchairs and beds in multiple sizes and colors, with online ordering and delivery throughout Kosovo.'], 'sr' => ['Prekrivači za Sofe i Krevete Online | B-Brillant', 'Moderni prekrivači za sofe, fotelje i krevete u različitim dimenzijama i bojama, sa dostavom širom Kosova.']],
        'products.postava' => ['path' => '/postava', 'sq' => ['Set Çarçafësh Online në Kosovë | Postava Krevati', 'Sete çarçafësh dhe postava për krevat tek e dopio, në përmasa dhe ngjyra të ndryshme, me porosi online dhe dërgesë në Kosovë.'], 'en' => ['Bed Sheet Sets Online in Kosovo | Single & Double Beds', 'Bed sheet and bedding sets for single and double beds in multiple sizes and colors, with online ordering and delivery in Kosovo.'], 'sr' => ['Posteljina Online na Kosovu | Setovi za Krevet', 'Setovi posteljine za singl i bračne krevete u različitim dimenzijama i bojama, sa online poručivanjem i dostavom.']],
        'products.tepiha' => ['path' => '/tepiha', 'sq' => ['Tepiha Online në Kosovë | Modern, Hali & Klasik', 'Tepiha modernë, klasikë dhe Hali për sallon, dhomë gjumi e korridor, me shumë përmasa, ngjyra dhe dërgesë në Kosovë.'], 'en' => ['Rugs Online in Kosovo | Modern & Classic Carpets', 'Modern, classic and Hali rugs for living rooms, bedrooms and hallways in multiple sizes and colors, with delivery across Kosovo.'], 'sr' => ['Tepisi Online na Kosovu | Moderni i Klasični', 'Moderni, klasični i Hali tepisi za dnevnu sobu, spavaću sobu i hodnik, u više dimenzija i boja, sa dostavom.']],
        'products.batanije' => ['path' => '/batanije', 'sq' => ['Batanije dhe Qebe Online në Kosovë | B-Brillant', 'Batanije dhe qebe të buta për një ose dy persona, krevat e divan, në përmasa dhe ngjyra të ndryshme me dërgesë në Kosovë.'], 'en' => ['Blankets Online in Kosovo | Single & Double Beds', 'Soft blankets for one or two people, beds and sofas, available in multiple sizes and colors with delivery throughout Kosovo.'], 'sr' => ['Ćebad Online na Kosovu | Za Jednu i Dve Osobe', 'Mekana ćebad za jednu ili dve osobe, krevete i sofe, u različitim dimenzijama i bojama sa dostavom širom Kosova.']],
        'products.jastekdekorues' => ['path' => '/jastekdekorues', 'sq' => ['Jastëkë Dekorues Online në Kosovë | B-Brillant', 'Jastëkë dekorues modernë për sallon, divan, kolltuk dhe dhomë gjumi në ngjyra e modele të ndryshme me dërgesë.'], 'en' => ['Decorative Cushions Online in Kosovo | B-Brillant', 'Modern decorative cushions for living rooms, sofas, armchairs and bedrooms in a variety of colors and designs.'], 'sr' => ['Dekorativni Jastuci Online na Kosovu | B-Brillant', 'Moderni dekorativni jastuci za dnevnu sobu, sofu, fotelju i spavaću sobu u raznim bojama i dezenima.']],
        'products.tepihebanjo' => ['path' => '/tepihebanjo', 'sq' => ['Tepiha Banjo Online në Kosovë | Antirrëshqitës', 'Tepiha dhe tapeta banjoje antirrëshqitëse, të buta dhe absorbuese në ngjyra e modele të ndryshme me dërgesë në Kosovë.'], 'en' => ['Bathroom Rugs Online in Kosovo | Non-Slip Bath Mats', 'Soft, absorbent and non-slip bathroom rugs and bath mats in a variety of colors and designs with delivery across Kosovo.'], 'sr' => ['Tepisi za Kupatilo Online | Neklizajuće Prostirke', 'Mekani, upijajući i neklizajući tepisi i prostirke za kupatilo u različitim bojama i dezenima sa dostavom.']],
        'products.posteqia' => ['path' => '/posteqia', 'sq' => ['Lëkurë Pelushi dhe Posteqia Online | B-Brillant', 'Lëkurë pelushi dhe posteqia të buta për divan, kolltuk, krevat dhe dekor modern me porosi online e dërgesë në Kosovë.'], 'en' => ['Faux Fur Rugs & Throws Online in Kosovo | B-Brillant', 'Soft faux fur rugs and throws for sofas, armchairs, beds and modern home decor, available to order online in Kosovo.'], 'sr' => ['Veštačko Krzno i Prostirke Online | B-Brillant', 'Mekano veštačko krzno i prostirke za sofe, fotelje, krevete i moderan kućni dekor sa dostavom na Kosovu.']],
        'products.garnishte' => ['path' => '/garnishte', 'sq' => ['Garnishte dhe Shina Perdesh në Kosovë | B-Brillant', 'Garnishte alumini e plastike dhe shina për perde në dimensione e ngjyra të ndryshme, me porosi dhe dërgesë në Kosovë.'], 'en' => ['Curtain Rods & Rails in Kosovo | B-Brillant', 'Aluminium and plastic curtain rods and rails in multiple sizes and colors, available to order with delivery throughout Kosovo.'], 'sr' => ['Garnišne i Šine za Zavese na Kosovu | B-Brillant', 'Aluminijumske i plastične garnišne i šine za zavese u različitim dimenzijama i bojama sa dostavom širom Kosova.']],
    ];

    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);
        $routeName = $request->route()?->getName();

        if (!isset(self::CATEGORIES[$routeName]) || !method_exists($response, 'getContent')) {
            return $response;
        }

        $html = (string) $response->getContent();
        if (stripos((string) $response->headers->get('Content-Type'), 'text/html') === false) {
            return $response;
        }

        $locale = in_array(App::getLocale(), ['sq', 'en', 'sr'], true) ? App::getLocale() : 'sq';
        $seo = self::CATEGORIES[$routeName];
        [$title, $description] = $seo[$locale];
        $base = url($seo['path']);
        $canonical = $locale === 'sq' ? $base : $base.'?lang='.$locale;
        $alternates = '<link rel="alternate" hreflang="sq" href="'.e($base).'">'
            .'<link rel="alternate" hreflang="en" href="'.e($base.'?lang=en').'">'
            .'<link rel="alternate" hreflang="sr" href="'.e($base.'?lang=sr').'">'
            .'<link rel="alternate" hreflang="x-default" href="'.e($base).'">';

        $html = preg_replace('/<html\b[^>]*>/i', '<html lang="'.$locale.'">', $html, 1);
        $html = preg_replace('/<title>.*?<\/title>/is', '<title>'.e($title).'</title>', $html, 1);
        $html = preg_replace('/<meta\s+name=["\']description["\'][^>]*>/i', '<meta name="description" content="'.e($description).'">', $html, 1);
        $html = preg_replace('/<link\s+rel=["\']canonical["\'][^>]*>/i', '<link rel="canonical" href="'.e($canonical).'">'.$alternates, $html, 1);
        $html = preg_replace('/<meta\s+property=["\']og:title["\'][^>]*>/i', '<meta property="og:title" content="'.e($title).'">', $html, 1);
        $html = preg_replace('/<meta\s+property=["\']og:description["\'][^>]*>/i', '<meta property="og:description" content="'.e($description).'">', $html, 1);
        $html = preg_replace('/<meta\s+property=["\']og:url["\'][^>]*>/i', '<meta property="og:url" content="'.e($canonical).'">', $html, 1);
        $html = preg_replace('/<meta\s+name=["\']twitter:title["\'][^>]*>/i', '<meta name="twitter:title" content="'.e($title).'">', $html, 1);
        $html = preg_replace('/<meta\s+name=["\']twitter:description["\'][^>]*>/i', '<meta name="twitter:description" content="'.e($description).'">', $html, 1);
        $html = preg_replace('/"inLanguage"\s*:\s*"[^"]+"/i', '"inLanguage": "'.$locale.'"', $html);
        $html = preg_replace('/<\/head>/i', '<meta property="og:locale" content="'.($locale === 'en' ? 'en_US' : ($locale === 'sr' ? 'sr_RS' : 'sq_XK')).'">'
            .'<meta property="og:locale:alternate" content="sq_XK">'
            .'<meta property="og:locale:alternate" content="en_US">'
            .'<meta property="og:locale:alternate" content="sr_RS">' . "\n</head>", $html, 1);

        $response->setContent($html);
        return $response;
    }
}
