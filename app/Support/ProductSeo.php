<?php

namespace App\Support;

use Illuminate\Support\Str;

class ProductSeo
{
    public static function localized(object $product, string $locale): array
    {
        $locale = in_array($locale, ['sq', 'en', 'sr'], true) ? $locale : 'sq';
        $name = self::name((string) $product->name, $locale);
        $category = self::category((string) $product->category, $locale);

        if ($locale === 'en') {
            $description = "Buy {$name} online from B-Brillant. {$category} for modern homes, with prices, product details and delivery throughout Kosovo.";
        } elseif ($locale === 'sr') {
            $description = "Kupite {$name} online u B-Brillantu. {$category} za moderan dom, sa cenama, detaljima proizvoda i dostavom širom Kosova.";
        } else {
            $rawDescription = trim(strip_tags((string) ($product->description ?? '')));
            $description = $rawDescription !== ''
                ? $rawDescription
                : "{$product->name} nga B-Brillant. Porosit online me çmim, detaje dhe dërgesë në gjithë Kosovën.";
        }

        return [
            'name' => $name,
            'category' => $category,
            'title' => Str::limit("{$name} – {$category} | B-Brillant", 60, ''),
            'description' => Str::limit($description, 155),
        ];
    }

    private static function name(string $name, string $locale): string
    {
        if ($locale === 'sq') {
            return $name;
        }

        $translations = $locale === 'en' ? [
            'garnishte plastike' => 'Plastic Curtain Rail',
            'garnishte plastik' => 'Plastic Curtain Rail',
            'garnishte alumini' => 'Aluminium Curtain Rail',
            'perde ditore' => 'Sheer Curtain',
            'perde anësore' => 'Side Curtain',
            'perde anesore' => 'Side Curtain',
            'tepih' => 'Rug',
            'tepiha' => 'Rugs',
            'batanije' => 'Blanket',
            'mbulesa' => 'Cover',
            'jastëk' => 'Cushion',
            'jastek' => 'Cushion',
            'postava' => 'Bed Sheet Set',
        ] : [
            'garnishte plastike' => 'Plastična Garnišna',
            'garnishte plastik' => 'Plastična Garnišna',
            'garnishte alumini' => 'Aluminijumska Garnišna',
            'perde ditore' => 'Dnevna Zavesa',
            'perde anësore' => 'Bočna Zavesa',
            'perde anesore' => 'Bočna Zavesa',
            'tepih' => 'Tepih',
            'tepiha' => 'Tepisi',
            'batanije' => 'Ćebe',
            'mbulesa' => 'Prekrivač',
            'jastëk' => 'Jastuk',
            'jastek' => 'Jastuk',
            'postava' => 'Posteljina',
        ];

        foreach ($translations as $source => $translation) {
            if (mb_strtolower(trim($name)) === $source) {
                return $translation;
            }
        }

        return $name;
    }

    private static function category(string $category, string $locale): string
    {
        $key = mb_strtolower(trim($category));
        $categories = [
            'sq' => [
                'tepiha' => 'Tepiha në Kosovë', 'perde' => 'Perde në Kosovë',
                'garnishte' => 'Garnishte për perde', 'batanije' => 'Batanije',
                'mbulesa' => 'Mbulesa', 'jastekdekorues' => 'Jastëkë dekorues',
                'postava' => 'Sete çarçafësh', 'tepihebanjo' => 'Tepiha banjoje',
                'posteqia' => 'Lëkurë pelushi',
            ],
            'en' => [
                'tepiha' => 'Rugs in Kosovo', 'perde' => 'Curtains in Kosovo',
                'garnishte' => 'Curtain Rails and Rods', 'batanije' => 'Blankets',
                'mbulesa' => 'Sofa and Bed Covers', 'jastekdekorues' => 'Decorative Cushions',
                'postava' => 'Bed Sheet Sets', 'tepihebanjo' => 'Bathroom Rugs',
                'posteqia' => 'Faux Fur Rugs',
            ],
            'sr' => [
                'tepiha' => 'Tepisi na Kosovu', 'perde' => 'Zavese na Kosovu',
                'garnishte' => 'Garnišne i Šine za Zavese', 'batanije' => 'Ćebad',
                'mbulesa' => 'Prekrivači za Sofe i Krevete', 'jastekdekorues' => 'Dekorativni Jastuci',
                'postava' => 'Posteljina', 'tepihebanjo' => 'Tepisi za Kupatilo',
                'posteqia' => 'Prostirke od Veštačkog Krzna',
            ],
        ];

        return $categories[$locale][$key] ?? ($locale === 'en' ? 'Home Products' : ($locale === 'sr' ? 'Proizvodi za Dom' : 'Produkte për shtëpi'));
    }
}
