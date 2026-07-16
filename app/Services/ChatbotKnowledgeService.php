<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Throwable;

class ChatbotKnowledgeService
{
    private const PRODUCT_LIMIT = 5;

    public function build(
        string $message,
        array $history = [],
        array $contextProductIds = [],
        array $cart = []
    ): array {
        $current = $this->normalize($message);
        $intent = $this->categoryIntent($current);
        $historyIntent = $this->historyIntent($history);
        $operational = $this->isOperationalQuestion($current);
        $followUp = $this->isFollowUp($current);

        if ($intent === null && $historyIntent !== null && $followUp && ! $operational) {
            $intent = $historyIntent;
        }

        $greetingOnly = $this->isGreetingOnly($current);
        $explicitProductSearch = $this->looksLikeProductSearch($current, $operational);
        $generalQuestion = $this->isGeneralQuestion($current);
        $productSearch = ! $greetingOnly
            && ! $operational
            && ($explicitProductSearch
                || ($followUp && $historyIntent !== null && $contextProductIds !== [])
                || ($intent !== null && ! $generalQuestion));
        $terms = $productSearch ? $this->searchTerms($message, $intent) : [];
        if ($productSearch && $followUp && $this->ordinalProductId($message, $contextProductIds) === null) {
            $historyTerms = $this->searchTerms($this->recentConversationText($history), $intent);
            $stableHistoryTerms = array_filter(
                $historyTerms['required'],
                fn (string $term) => ! $this->isColorTerm($term)
            );
            $currentStableTerms = array_filter(
                $terms['required'],
                fn (string $term) => ! $this->isColorTerm($term)
            );

            if ($currentStableTerms === [] && ! $this->wantsAlternative($message)) {
                $terms['required'] = array_values(array_unique(array_merge($stableHistoryTerms, $terms['required'])));
            }
        }
        $products = [];
        $inventory = [];
        $catalogAvailable = $productSearch ? true : null;

        if ($productSearch) {
            try {
                $catalog = Product::query()
                    ->where('is_active', true)
                    ->orderByDesc('id')
                    ->get([
                        'id', 'name', 'slug', 'price', 'description', 'image_path', 'stock',
                        'category', 'subcategory', 'sizes', 'color_variants', 'sku', 'barcode',
                    ]);

                $inventory = $this->inventorySummary($catalog);
                $products = $this->rankProducts(
                    $catalog,
                    $message,
                    $intent,
                    $terms,
                    array_values(array_unique(array_map('intval', $contextProductIds))),
                    $followUp
                );
            } catch (Throwable $exception) {
                $catalogAvailable = false;
                Log::warning('Brillant chatbot catalog search failed.', ['exception_class' => $exception::class]);
            }
        }

        $noExactMatch = $productSearch && $catalogAvailable === true && $products === [];
        $action = $this->suggestedAction($current, $intent);
        $cartSummary = $this->cartSummary($cart);

        return [
            'intent' => $intent,
            'products' => $products,
            'inventory' => $inventory,
            'action' => $action,
            'catalog_searched' => $productSearch,
            'catalog_available' => $catalogAvailable,
            'no_exact_match' => $noExactMatch,
            'cart' => $cartSummary,
            'prompt_context' => $this->promptContext(
                $products,
                $inventory,
                $cartSummary,
                $catalogAvailable,
                $productSearch,
                $noExactMatch,
                $intent
            ),
        ];
    }

    public function fallbackReply(string $message, array $knowledge): string
    {
        $products = $knowledge['products'] ?? [];
        $intent = $knowledge['intent'] ?? null;

        if (($knowledge['no_exact_match'] ?? false) === true) {
            $label = is_array($intent) ? mb_strtolower((string) ($intent['label'] ?? 'produkti që kërkove')) : 'produkti që kërkove';

            return "{$label} nuk figuron aktualisht në katalogun aktiv të B-Brillant me kërkesat që dhe. Mund të të ndihmoj të gjesh alternativën më të afërt, ose mund të na shkruash në WhatsApp që ta kontrollojmë me ekipin.";
        }

        if ($products !== []) {
            $names = collect($products)->take(3)->pluck('name')->implode(', ');

            return "Gjeta këto opsione reale në katalog: {$names}. Shiko kartat më poshtë për çmimin, përmasat dhe faqen e secilit produkt.";
        }

        if (is_array($intent)) {
            $label = mb_strtolower((string) ($intent['label'] ?? 'produktet'));

            return "Mund të të ndihmoj me {$label}. Hape koleksionin për modelet aktive ose më trego ngjyrën dhe përmasën që po kërkon.";
        }

        $normalized = $this->normalize($message);

        if (Str::contains($normalized, ['gjurmo', 'tracking', 'status poros', 'kodi poros'])) {
            return 'Hape “Gjurmo porosinë” dhe shkruaj kodin e gjurmimit që ke marrë pas porosisë. Për siguri, mos dërgo këtu të dhëna të kartelës ose fjalëkalime.';
        }

        if ($this->isLocationQuestion($normalized)
            || Str::contains($normalized, ['kontakt', 'telefon', 'whatsapp'])) {
            return 'B-Brillant gjendet në Rrugën Gjergj Fishta, 14000 Lipjan. Për ndihmë të shpejtë mund të na shkruash në WhatsApp në +383 44 960 661.';
        }

        if (Str::contains($normalized, ['derges', 'transport'])) {
            return 'B-Brillant bën dërgesa në Kosovë. Afati dhe kostoja përfundimtare konfirmohen gjatë porosisë ose nga ekipi në WhatsApp.';
        }

        if (Str::contains($normalized, ['shporta', 'cart'])) {
            $cart = (array) ($knowledge['cart'] ?? []);
            if (($cart['total_qty'] ?? 0) < 1) {
                return 'Shporta jote është bosh. Zgjidh një produkt dhe shtype “Shto në shportë” për të vazhduar.';
            }

            return 'Në shportë ke '.(int) $cart['total_qty'].' artikuj me total '
                .number_format((float) $cart['total_price'], 2).' €. Hape shportën për t’i kontrolluar ose ndryshuar.';
        }

        return 'Mund të të ndihmoj me produktet reale të katalogut, çmimet, përmasat, ngjyrat, porosinë, dërgesën dhe gjurmimin. Më thuaj çfarë po kërkon dhe, nëse mundesh, kategorinë, ngjyrën ose përmasën.';
    }

    private function rankProducts(
        Collection $catalog,
        string $message,
        ?array $intent,
        array $terms,
        array $contextProductIds = [],
        bool $followUp = false
    ): array {
        $filtered = $catalog->filter(function (Product $product) use ($intent) {
            if ($intent === null) {
                return true;
            }

            if ((string) $product->category !== (string) $intent['category']) {
                return false;
            }

            return $intent['subcategory'] === null
                || (string) $product->subcategory === (string) $intent['subcategory'];
        });

        if ($this->requiresInStock($message)) {
            $filtered = $filtered->filter(fn (Product $product) => (string) $product->category !== 'mbulesa'
                && $this->hasAvailableOption($product));
        }

        $alternative = $this->wantsAlternative($message);
        if ($contextProductIds !== [] && Str::contains($this->normalize($message), ['tjeter', 'alternative', 'another'])) {
            $filtered = $filtered->where('id', '!=', $contextProductIds[0]);
        }

        $ordinalProductId = $followUp ? $this->ordinalProductId($message, $contextProductIds) : null;
        if ($ordinalProductId !== null) {
            $filtered = $filtered->where('id', $ordinalProductId);
        }

        $required = $terms['required'];
        $soft = $terms['soft'];
        $dimensions = $this->dimensionNeedles($message);

        $ranked = $filtered->map(function (Product $product) use (
            $required,
            $soft,
            $dimensions,
            $message,
            $followUp,
            $alternative,
            $contextProductIds
        ) {
            $fields = $this->searchableFields($product);

            foreach ($required as $term) {
                if (! $this->termMatches($term, $fields)) {
                    return null;
                }
            }

            foreach ($dimensions as $dimensionSet) {
                $dimensionMatch = collect($dimensionSet)->contains(fn (string $needle) => str_contains($fields['dimensions'], $needle)
                    || str_contains($fields['description_dimensions'], $needle)
                );

                // Kur modeli identifikohet qartë, por admini s'i ka regjistruar
                // përmasat, shfaqe si rezultat për konfirmim në vend se të thuash
                // gabimisht se produkti nuk ekziston.
                if (! $dimensionMatch
                    && ($fields['dimensions'] !== '' || ! $this->hasStrongIdentityMatch($required, $fields))) {
                    return null;
                }
            }

            $score = $this->score($fields, $required, $soft, $message);
            if ($followUp && ! $alternative && in_array((int) $product->id, $contextProductIds, true)) {
                $score += 55;
            }
            if ($this->hasAvailableOption($product)) {
                $score += 4;
            }

            return ['product' => $product, 'score' => $score];
        })->filter();

        $sortMode = $this->sortMode($message);
        $ranked = $ranked->sort(function (array $left, array $right) use ($sortMode) {
            if ($left['score'] !== $right['score']) {
                return $right['score'] <=> $left['score'];
            }

            if ($sortMode !== null) {
                $leftPrice = $this->priceRange($left['product'])['min'] ?? PHP_FLOAT_MAX;
                $rightPrice = $this->priceRange($right['product'])['min'] ?? PHP_FLOAT_MAX;
                if ($leftPrice !== $rightPrice) {
                    return $sortMode === 'cheap' ? $leftPrice <=> $rightPrice : $rightPrice <=> $leftPrice;
                }
            }

            return $right['product']->id <=> $left['product']->id;
        });

        return $ranked->take(self::PRODUCT_LIMIT)
            ->map(fn (array $row) => $this->serializeProduct($row['product'], $message))
            ->values()->all();
    }

    private function searchableFields(Product $product): array
    {
        $sizes = $this->sizes($product);
        $colors = $this->colors($product);

        return [
            'name' => $this->normalize((string) $product->name),
            'description' => $this->normalize(strip_tags((string) $product->description)),
            'description_dimensions' => $this->normalizeDimensions(
                $this->normalize(strip_tags((string) $product->description))
            ),
            'category' => $this->normalize((string) $product->category.' '.(string) $product->subcategory),
            'dimensions' => $this->normalizeDimensions(collect($sizes)->pluck('label')->implode(' ')),
            'colors' => $this->normalize(collect($colors)->pluck('name')->implode(' ')),
            'codes' => $this->normalize(
                (string) $product->sku.' '.(string) $product->barcode.' '.collect($sizes)->pluck('barcode')->filter()->implode(' ')
                .' '.(string) $product->slug
            ),
        ];
    }

    private function termMatches(string $term, array $fields): bool
    {
        foreach ($this->expandedTerms($term) as $needle) {
            foreach ($fields as $field) {
                if ($needle !== '' && str_contains($field, $needle)) {
                    return true;
                }
            }
        }

        return false;
    }

    private function hasStrongIdentityMatch(array $terms, array $fields): bool
    {
        foreach ($terms as $term) {
            if ($this->isColorTerm($term)) {
                continue;
            }

            foreach ($this->expandedTerms($term) as $needle) {
                if ($needle !== '' && (str_contains($fields['name'], $needle) || str_contains($fields['codes'], $needle))) {
                    return true;
                }
            }
        }

        return false;
    }

    private function score(array $fields, array $required, array $soft, string $message): int
    {
        $score = 0;
        $phrase = $this->normalize($message);

        if (mb_strlen($phrase) >= 4 && str_contains($fields['name'], $phrase)) {
            $score += 100;
        }

        foreach (array_merge($required, $soft) as $term) {
            foreach ($this->expandedTerms($term) as $needle) {
                $score += str_contains($fields['codes'], $needle) ? 80 : 0;
                $score += str_contains($fields['name'], $needle) ? 45 : 0;
                $score += str_contains($fields['dimensions'], $needle) ? 40 : 0;
                $score += str_contains($fields['colors'], $needle) ? 35 : 0;
                $score += str_contains($fields['description'], $needle) ? 12 : 0;
            }
        }

        return $score;
    }

    private function serializeProduct(Product $product, string $message): array
    {
        $sizes = $this->sizes($product);
        $colors = $this->colors($product);
        $range = $this->priceRange($product);
        $matchedSize = $this->matchedSize($sizes, $message);
        $requestedDimensions = $this->requestedDimensionLabel($message);
        $isCover = (string) $product->category === 'mbulesa';

        if ($matchedSize !== null && $matchedSize['price'] !== null) {
            $priceText = number_format($matchedSize['price'], 2).' € ('.$matchedSize['label'].')';
        } elseif ($range['min'] !== null && $range['max'] !== null && $range['min'] !== $range['max']) {
            $priceText = number_format($range['min'], 2).'–'.number_format($range['max'], 2).' €';
        } elseif ($range['min'] !== null) {
            $priceText = number_format($range['min'], 2).' €';
        } else {
            $priceText = 'Shiko produktin';
        }

        if ($isCover) {
            $stockStatus = 'confirm';
            $stockLabel = 'Konfirmo stokun';
        } elseif ($matchedSize !== null) {
            $stockStatus = $matchedSize['stock'] > 0 ? 'in_stock' : 'out_of_stock';
            $stockLabel = $matchedSize['stock'] > 0 ? 'Në stok për këtë përmasë' : 'Pa stok për këtë përmasë';
        } elseif ($requestedDimensions !== null) {
            $stockStatus = 'confirm';
            $stockLabel = 'Konfirmo përmasën '.$requestedDimensions;
        } else {
            $available = $this->hasAvailableOption($product);
            $stockStatus = $available ? 'in_stock' : 'out_of_stock';
            $stockLabel = $available ? 'Në stok në sistem' : 'Pa stok në sistem';
        }

        return [
            'id' => (int) $product->id,
            'name' => (string) $product->name,
            'category' => (string) $product->category,
            'subcategory' => $product->subcategory ?: null,
            'sku' => $product->sku ?: null,
            'barcode' => $product->barcode ?: null,
            'description' => Str::limit(trim(strip_tags((string) $product->description)), 240, ''),
            'price' => $range['min'],
            'price_min' => $range['min'],
            'price_max' => $range['max'],
            'price_text' => $priceText,
            'stock_status' => $stockStatus,
            'stock_label' => $stockLabel,
            'matched_size' => $matchedSize,
            'requested_size' => $requestedDimensions,
            'requested_size_confirmed' => $requestedDimensions === null || $matchedSize !== null,
            'sizes' => array_slice($sizes, 0, 12),
            'colors' => array_slice(array_column($colors, 'name'), 0, 12),
            'image' => $product->image_url,
            'url' => route('products.show', $product->slug, false),
        ];
    }

    private function sizes(Product $product): array
    {
        $rows = is_array($product->sizes) ? $product->sizes : [];
        $basePrice = is_numeric($product->price) && (float) $product->price > 0
            ? (float) $product->price
            : null;
        $seen = [];
        $sizes = [];

        foreach ($rows as $row) {
            if (! is_array($row)) {
                continue;
            }

            $label = trim((string) ($row['label'] ?? ''));
            $key = $this->normalizeDimensions($label);
            if ($label === '' || isset($seen[$key])) {
                continue;
            }

            $seen[$key] = true;
            $sizes[] = [
                'label' => $label,
                'price' => is_numeric($row['price'] ?? null) && (float) $row['price'] > 0
                    ? (float) $row['price']
                    : $basePrice,
                'stock' => max(0, (int) ($row['stock'] ?? 0)),
                'barcode' => trim((string) ($row['barcode'] ?? '')) ?: null,
            ];
        }

        return $sizes;
    }

    private function colors(Product $product): array
    {
        $rows = is_array($product->color_variants) ? $product->color_variants : [];
        $colors = [];

        foreach ($rows as $row) {
            if (! is_array($row)) {
                continue;
            }

            $name = trim((string) ($row['name'] ?? ''));
            if ($name !== '') {
                $colors[$this->normalize($name)] = ['name' => $name];
            }
        }

        return array_values($colors);
    }

    private function priceRange(Product $product): array
    {
        $prices = collect($this->sizes($product))->pluck('price')->filter(fn ($price) => $price !== null);

        if ($prices->isEmpty() && is_numeric($product->price) && (float) $product->price > 0) {
            $prices = collect([(float) $product->price]);
        }

        return [
            'min' => $prices->isEmpty() ? null : (float) $prices->min(),
            'max' => $prices->isEmpty() ? null : (float) $prices->max(),
        ];
    }

    private function hasAvailableOption(Product $product): bool
    {
        $sizes = $this->sizes($product);

        if ($sizes !== []) {
            return collect($sizes)->contains(fn (array $size) => $size['stock'] > 0);
        }

        return (int) ($product->stock ?? 0) > 0;
    }

    private function matchedSize(array $sizes, string $message): ?array
    {
        $needles = $this->dimensionNeedles($message);

        foreach ($sizes as $size) {
            $normalized = $this->normalizeDimensions($size['label']);
            foreach ($needles as $dimensionSet) {
                if (collect($dimensionSet)->contains(fn (string $needle) => str_contains($normalized, $needle))) {
                    return $size;
                }
            }
        }

        return null;
    }

    private function categoryIntent(string $normalized): ?array
    {
        $best = null;
        $bestLength = -1;

        foreach ((array) config('chatbot.categories', []) as $key => $category) {
            foreach ((array) ($category['aliases'] ?? []) as $alias) {
                $alias = $this->normalize($alias);
                $length = mb_strlen($alias);

                if ($length > $bestLength && str_contains($normalized, $alias)) {
                    $best = ['key' => $key] + $category;
                    $bestLength = $length;
                }
            }
        }

        return $best;
    }

    private function historyIntent(array $history): ?array
    {
        foreach (array_reverse($history) as $item) {
            if (! in_array($item['role'] ?? null, ['user', 'assistant'], true)) {
                continue;
            }

            $intent = $this->categoryIntent($this->normalize((string) ($item['content'] ?? '')));
            if ($intent !== null) {
                return $intent;
            }
        }

        return null;
    }

    private function searchTerms(string $text, ?array $intent): array
    {
        $normalized = $this->normalizeDimensions($this->normalize($text));
        $tokens = preg_split('/[^a-z0-9]+/', $normalized) ?: [];
        $stopWords = collect((array) config('chatbot.stop_words', []))->map(fn ($word) => $this->normalize($word))->all();
        $generic = collect((array) ($intent['generic'] ?? []))->map(fn ($word) => $this->normalize($word))->all();
        $softWords = collect((array) config('chatbot.soft_preferences', []))->map(fn ($word) => $this->normalize($word))->all();
        $required = [];
        $soft = [];

        foreach ($tokens as $token) {
            $genericToken = collect($generic)->contains(function (string $word) use ($token) {
                return mb_strlen($word) >= 3 && (str_contains($token, $word) || str_contains($word, $token));
            });

            if (mb_strlen($token) < 2 || in_array($token, $stopWords, true) || $genericToken) {
                continue;
            }

            if (in_array($token, $softWords, true)) {
                $soft[] = $token;
            } elseif ((! preg_match('/^\d+$/', $token) || mb_strlen($token) >= 6)
                && ! preg_match('/^\d+(?:\.\d+)?x\d+(?:\.\d+)?$/', $token)) {
                $required[] = $token;
            }
        }

        return ['required' => array_values(array_unique($required)), 'soft' => array_values(array_unique($soft))];
    }

    private function expandedTerms(string $term): array
    {
        $normalized = $this->normalize($term);

        foreach ((array) config('chatbot.color_synonyms', []) as $group) {
            $group = collect($group)->map(fn ($value) => $this->normalize((string) $value))->unique()->values()->all();
            if (collect($group)->contains(fn (string $value) => $value === $normalized
                || (mb_strlen($normalized) >= 3 && (str_contains($value, $normalized) || str_contains($normalized, $value))))) {
                return $group;
            }
        }

        return [$normalized];
    }

    private function isColorTerm(string $term): bool
    {
        $normalized = $this->normalize($term);

        foreach ((array) config('chatbot.color_synonyms', []) as $group) {
            if (collect($group)->map(fn ($value) => $this->normalize((string) $value))
                ->contains(fn (string $value) => $value === $normalized
                    || (mb_strlen($normalized) >= 3 && (str_contains($value, $normalized) || str_contains($normalized, $value))))) {
                return true;
            }
        }

        return false;
    }

    private function ordinalProductId(string $message, array $contextProductIds): ?int
    {
        if ($contextProductIds === []) {
            return null;
        }

        $message = $this->normalize($message);
        $index = match (true) {
            Str::contains($message, ['te parin', 't parin', 'tparen', 'first', 'prvi']) => 0,
            Str::contains($message, ['te dytin', 't dytin', 'dyten', 'second', 'drugi']) => 1,
            Str::contains($message, ['te tretin', 't tretin', 'treten', 'third', 'treci']) => 2,
            Str::contains($message, ['te katertin', 't katertin', 'fourth', 'cetvrti']) => 3,
            Str::contains($message, ['te pestin', 't pestin', 'fifth', 'peti']) => 4,
            default => null,
        };

        return $index !== null && isset($contextProductIds[$index]) ? (int) $contextProductIds[$index] : null;
    }

    private function dimensionNeedles(string $text): array
    {
        $text = $this->normalizeDimensions($this->normalize($text));
        preg_match_all('/(\d+(?:[.,]\d+)?)x(\d+(?:[.,]\d+)?)/', $text, $matches, PREG_SET_ORDER);
        $dimensions = [];

        foreach ($matches as $match) {
            $left = str_replace(',', '.', $match[1]);
            $right = str_replace(',', '.', $match[2]);
            $needles = [$left.'x'.$right, $right.'x'.$left];

            if ((float) $left > 0 && (float) $left <= 20 && (float) $right > 0 && (float) $right <= 20) {
                $leftCm = (string) (int) round((float) $left * 100);
                $rightCm = (string) (int) round((float) $right * 100);
                $needles[] = $leftCm.'x'.$rightCm;
                $needles[] = $rightCm.'x'.$leftCm;
            }

            $dimensions[] = array_values(array_unique($needles));
        }

        preg_match_all('/\b(\d+(?:[.,]\d+)?)\s*(?:m|meter|metra|metre|meters)\b/', $text, $lengths, PREG_SET_ORDER);
        foreach ($lengths as $length) {
            $value = str_replace(',', '.', $length[1]);
            $dimensions[] = [$value, $value.'m', $value.'meter', $value.'metra'];
        }

        // Shprehjet e zakonshme të klientëve për madhësinë e shtratit.
        // Për dy persona përfshijmë edhe 200x220, sepse kjo është përmasa
        // standarde e shumë batanijeve dopio në katalog.
        if (preg_match('/\b(?:d+y|dy|2)\s*(?:persona|person|veta)\b/', $text)
            || Str::contains($text, ['dopio', 'double', 'cift', 'matrimonial'])) {
            $dimensions[] = ['200x200', '200x220', '220x200'];
        } elseif (preg_match('/\b(?:nje|1)\s*(?:person|veta)\b/', $text)
            || Str::contains($text, ['teke', 'single'])) {
            $dimensions[] = ['150x200', '200x150'];
        }

        return collect($dimensions)->unique(fn (array $needles) => implode('|', $needles))->values()->all();
    }

    private function requestedDimensionLabel(string $text): ?string
    {
        $text = $this->normalizeDimensions($this->normalize($text));

        if (preg_match('/(\d+(?:[.,]\d+)?)x(\d+(?:[.,]\d+)?)/', $text, $match)) {
            return str_replace(',', '.', $match[1]).'x'.str_replace(',', '.', $match[2]);
        }

        if (preg_match('/\b(\d+(?:[.,]\d+)?)\s*(?:m|meter|metra|metre|meters)\b/', $text, $match)) {
            return str_replace(',', '.', $match[1]).' m';
        }

        if (preg_match('/\b(?:d+y|dy|2)\s*(?:persona|person|veta)\b/', $text)
            || Str::contains($text, ['dopio', 'double', 'cift', 'matrimonial'])) {
            return 'për dy persona (rreth 200x200 / 200x220)';
        }

        if (preg_match('/\b(?:nje|1)\s*(?:person|veta)\b/', $text)
            || Str::contains($text, ['teke', 'single'])) {
            return 'për një person (rreth 150x200)';
        }

        return null;
    }

    private function normalizeDimensions(string $value): string
    {
        $value = str_replace('×', 'x', $value);
        $value = preg_replace('/(?<=\d)\s*(?:me|by)\s*(?=\d)/u', 'x', $value) ?? $value;
        $value = preg_replace('/\s*x\s*/u', 'x', $value) ?? $value;
        $value = preg_replace('/\s*cm\b/u', '', $value) ?? $value;

        return $value;
    }

    private function inventorySummary(Collection $catalog): array
    {
        return $catalog->groupBy('category')->map->count()->sortDesc()->all();
    }

    private function promptContext(
        array $products,
        array $inventory,
        array $cart,
        ?bool $catalogAvailable,
        bool $catalogSearched,
        bool $noExactMatch,
        ?array $intent
    ): string
    {
        $business = (array) config('chatbot.business', []);
        $promptProducts = collect($products)
            ->map(fn (array $product) => collect($product)->except(['image'])->all())
            ->values()->all();
        $pages = collect((array) config('chatbot.pages', []))->map(function (array $page) {
            return ['label' => $page['label'], 'url' => route($page['route'], [], false)];
        })->values()->all();
        $categories = collect((array) config('chatbot.categories', []))->map(function (array $category) {
            return [
                'label' => $category['label'],
                'url' => route($category['route'], [], false),
            ];
        })->unique('url')->values()->all();

        return json_encode([
            'business' => $business,
            'website_pages' => $pages,
            'categories' => $categories,
            'request_analysis' => [
                'catalog_searched' => $catalogSearched,
                'no_exact_match' => $noExactMatch,
                'requested_collection' => is_array($intent) ? ($intent['label'] ?? null) : null,
            ],
            'catalog_available' => $catalogAvailable,
            'active_inventory_counts' => $inventory,
            'matching_products' => $promptProducts,
            'current_cart' => $cart,
        ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) ?: '{}';
    }

    private function cartSummary(array $cart): array
    {
        $items = collect($cart)->take(20)->map(function ($item) {
            $item = is_array($item) ? $item : [];
            $quantity = max(1, (int) ($item['qty'] ?? 1));
            $unitPrice = max(0, (float) ($item['price'] ?? 0));
            $curtain = is_array($item['curtain'] ?? null) ? $item['curtain'] : null;

            return [
                'name' => Str::limit(trim(strip_tags((string) ($item['name'] ?? 'Produkt'))), 100, ''),
                'quantity' => $quantity,
                'unit_price' => round($unitPrice, 2),
                'subtotal' => round($unitPrice * $quantity, 2),
                'size' => isset($item['size']) ? Str::limit(strip_tags((string) $item['size']), 80, '') : null,
                'color' => isset($item['color']) ? Str::limit(strip_tags((string) $item['color']), 50, '') : null,
                'curtain' => $curtain ? [
                    'width' => isset($curtain['width']) ? (float) $curtain['width'] : null,
                    'height' => isset($curtain['height']) ? (float) $curtain['height'] : null,
                    'fabric_meters' => isset($curtain['meters']) ? (float) $curtain['meters'] : null,
                    'fold' => isset($curtain['fold_label'])
                        ? Str::limit(strip_tags((string) $curtain['fold_label']), 60, '')
                        : null,
                ] : null,
            ];
        })->values();

        return [
            'total_qty' => $items->sum('quantity'),
            'total_price' => round((float) $items->sum('subtotal'), 2),
            'items' => $items->all(),
        ];
    }

    private function suggestedAction(string $normalized, ?array $intent): ?array
    {
        if ($this->isLocationQuestion($normalized)) {
            return ['label' => 'Kontakti dhe adresa', 'url' => route('contact', [], false)];
        }

        if ($intent !== null) {
            return [
                'label' => $intent['action_label'] ?? 'Shiko '.$intent['label'],
                'url' => route($intent['route'], [], false),
            ];
        }

        foreach ((array) config('chatbot.pages', []) as $page) {
            foreach ((array) ($page['keywords'] ?? []) as $keyword) {
                if (str_contains($normalized, $this->normalize($keyword))) {
                    return ['label' => $page['label'], 'url' => route($page['route'], [], false)];
                }
            }
        }

        return null;
    }

    private function isGreetingOnly(string $text): bool
    {
        $words = array_values(array_filter(preg_split('/[^a-z]+/', $text) ?: []));
        $greetings = ['pershendetje', 'hello', 'hi', 'tung', 'tungjatjeta', 'miredita', 'mirdita', 'hey'];
        $allowed = array_merge($greetings, ['bro', 'bruda', 'there']);

        return collect($words)->contains(fn (string $word) => in_array($word, $greetings, true))
            && collect($words)->every(fn (string $word) => in_array($word, $allowed, true));
    }

    private function isOperationalQuestion(string $text): bool
    {
        if ($this->isLocationQuestion($text)) {
            return true;
        }

        return Str::contains($text, [
            'kontakt', 'telefon', 'whatsapp', 'orar', 'hapur', 'mbyllur',
            'derges', 'transport', 'gjurmo', 'tracking', 'status poros', 'kodi poros',
            'pagese', 'pagesa', 'paguaj', 'payment', 'kthim', 'kthej', 'garanci', 'privacy', 'privates',
            'login', 'llogari', 'regjistr', 'shporta', 'checkout', 'kush jeni', 'si jeni', 'qka dini', 'cka dini',
        ]);
    }

    private function isLocationQuestion(string $text): bool
    {
        $text = $this->normalize($text);

        if (Str::contains($text, [
            'adresa', 'adresen', 'lokacion', 'lokacioni', 'lokacionin', 'location',
            'ku jeni', 'ku e keni lokalin', 'ku e keni dyqanin', 'ku ndodheni', 'ku ndodhet',
        ])) {
            return true;
        }

        // Pranon edhe dialekt e gabime të zakonshme: gjindeni, gjindet,
        // gjendeni, gjendeni?, ku gjindet dyqani, etj.
        return preg_match('/\bku\s+(?:gj(?:e|i)nd(?:eni|et|eteni)|jeni)\b/u', $text) === 1;
    }

    private function looksLikeProductSearch(string $text, bool $operational): bool
    {
        if ($operational) {
            return false;
        }

        if (Str::contains($text, ['faleminderit', 'rrofsh', 'thanks', 'thank you'])) {
            return false;
        }

        if (Str::contains($text, [
            'produkt', 'katalog', 'qka keni', 'cka keni', 'çka keni', 'qfare shisni', 'çfarë shisni',
            'a keni', 'a kena', 'a kini', 'a ka ', 'e keni', 'ne stok', 'në stok', 'disponuesh',
            'sa kushton', 'sa osht', 'sa eshte', 'sa është', 'cmimi', 'çmimi', 'me gjej', 'ma gjej',
            'dua ta blej', 'du me ble', 'porosit', 'modelin', 'permasen', 'përmasën',
        ])) {
            return true;
        }

        if ($this->dimensionNeedles($text) !== []) {
            return true;
        }

        // Një kod/model i shkurtër si "Otto 1010" duhet kërkuar në katalog,
        // por pyetjet e zakonshme nuk duhen kthyer automatikisht në kërkim produkti.
        return preg_match('/\b[a-z]{2,}[\s-]*\d{2,}\b|\b\d{5,}\b/u', $text) === 1;
    }

    private function isGeneralQuestion(string $text): bool
    {
        if (Str::contains($text, [
            'si ta ', 'si te ', 'si të ', 'si mund', 'si duhet', 'si pastro', 'si lahet', 'si laj',
            'si matet', 'si kombino', 'si zgjedh', 'si vendos', 'si perdor', 'si përdor',
            'pse ', 'qka eshte', 'cka eshte', 'çka është', 'cfare eshte', 'çfarë është',
            'qka dmth', 'cka dmth', 'çka dmth', 'me trego per', 'më trego për',
            'a mund ta laj', 'a mund ta pastroj', 'a pershtatet', 'a përshtatet',
            'cila ngjyre', 'cilen ngjyre', 'çfarë ngjyre', 'qfare ngjyre',
            'keshille', 'këshillë', 'ide per', 'ide për',
        ])) {
            return true;
        }

        return Str::endsWith($text, '?')
            && ! Str::contains($text, [
                'a keni', 'a kena', 'a kini', 'a ka ', 'e keni', 'ne stok', 'në stok',
                'sa kushton', 'sa osht', 'sa eshte', 'sa është', 'cmimi', 'çmimi',
                'me gjej', 'ma gjej', 'porosit',
            ]);
    }

    private function isFollowUp(string $text): bool
    {
        return Str::startsWith($text, [
            'po ', 'edhe ', 'e ', 'a ka', 'cilin', 'cilen', 'kete', 'atë', 'ate',
            'te parin', 'te dytin', 'te tretin', 't parin', 't dytin', 't tretin',
        ])
            || Str::contains($text, ['ngjyre', 'ngjyrë', 'madhesi', 'madhësi', 'dimension', 'permas', 'përmas', 'stok', 'cmim', 'çmim', 'kushton', 'me lire', 'më lirë']);
    }

    private function recentConversationText(array $history): string
    {
        return collect($history)->take(-6)
            ->filter(fn (array $item) => ($item['role'] ?? null) === 'user')
            ->pluck('content')->filter()->implode(' ');
    }

    private function sortMode(string $message): ?string
    {
        $message = $this->normalize($message);

        if (Str::contains($message, ['me lire', 'lire', 'cheap', 'budget'])) {
            return 'cheap';
        }

        if (Str::contains($message, ['premium', 'me shtrenjte', 'shtrenjte', 'expensive'])) {
            return 'expensive';
        }

        return null;
    }

    private function requiresInStock(string $message): bool
    {
        $message = $this->normalize($message);

        return ! Str::contains($message, ['pa stok', 'out of stock'])
            && Str::contains($message, ['ne stok', 'ka stok', 'me stok', 'disponuesh', 'in stock', 'available']);
    }

    private function wantsAlternative(string $message): bool
    {
        $message = $this->normalize($message);

        return Str::contains($message, [
            'tjeter', 'alternative', 'another', 'me lire', 'cheap', 'budget', 'me shtrenjte', 'expensive',
        ]);
    }

    private function normalize(string $value): string
    {
        $value = Str::lower(Str::ascii($value));
        $value = preg_replace('/\s+/u', ' ', $value) ?? $value;

        return trim($value);
    }
}
