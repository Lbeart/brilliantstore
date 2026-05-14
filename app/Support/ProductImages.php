<?php

namespace App\Support;

class ProductImages
{
    public static function urls(mixed $value, ?string $placeholder = null, mixed $context = null): array
    {
        $urls = [];

        foreach (self::decode($value) as $path) {
            $url = self::normalize($path, $context);
            if ($url) {
                $urls[] = $url;
            }
        }

        if (empty($urls)) {
            $fallback = self::fallbackFromContext($context);
            if ($fallback) {
                $urls[] = $fallback;
            }
        }

        if (empty($urls) && $placeholder) {
            $urls[] = $placeholder;
        }

        return array_values(array_unique($urls));
    }

    public static function url(mixed $value, ?string $placeholder = null, mixed $context = null): string
    {
        return self::urls($value, $placeholder, $context)[0] ?? ($placeholder ?: asset('images/placeholder-product.png'));
    }

    public static function decode(mixed $value): array
    {
        if (empty($value)) {
            return [];
        }

        if (is_array($value)) {
            return array_values(array_filter($value));
        }

        $raw = trim((string) $value);
        if ($raw === '') {
            return [];
        }

        if (preg_match('/\[[^\]]+\]/', $raw, $match)) {
            $raw = $match[0];
        }

        $decoded = json_decode($raw, true);
        if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
            return array_values(array_filter($decoded));
        }

        return [$raw];
    }

    private static function normalize(string $raw, mixed $context = null): ?string
    {
        $path = trim($raw, " \t\n\r\0\x0B\"'");
        if ($path === '') {
            return null;
        }

        if (preg_match('#^https?://#i', $path)) {
            if (str_contains($path, '/storage/images/')) {
                $path = ltrim(parse_url(str_replace('/storage/images/', '/images/', $path), PHP_URL_PATH) ?: '', '/');
                return self::existingAsset($path) ?: self::fallbackFromContext($context);
            }

            if (str_contains($path, '/storage/products/')) {
                $path = ltrim(parse_url(str_replace('/storage/products/', '/images/products/', $path), PHP_URL_PATH) ?: '', '/');
                return self::existingAsset($path) ?: self::fallbackFromContext($context);
            }

            $relative = ltrim(parse_url($path, PHP_URL_PATH) ?: '', '/');
            $host = parse_url($path, PHP_URL_HOST);
            $appHost = parse_url((string) config('app.url'), PHP_URL_HOST);
            $isLocalAsset = !$host || !$appHost || strcasecmp($host, $appHost) === 0;

            return self::existingAsset($relative)
                ?: self::findByBasename($relative)
                ?: ($isLocalAsset ? self::fallbackFromContext($context) : $path);
        }

        $path = ltrim($path, '/');
        $path = preg_replace('#^(public|storage)/#', '', $path);

        if ($path === '') {
            return null;
        }

        foreach (self::candidatePaths($path) as $candidate) {
            $asset = self::existingAsset($candidate);
            if ($asset) {
                return $asset;
            }
        }

        $byBasename = self::findByBasename($path);
        if ($byBasename) {
            return $byBasename;
        }

        return self::fallbackFromContext($context);
    }

    private static function candidatePaths(string $path): array
    {
        $paths = [$path];

        if (str_starts_with($path, 'products/')) {
            $paths[] = 'images/'.$path;
        }

        if (!str_starts_with($path, 'images/')) {
            $paths[] = 'images/'.$path;
            $paths[] = 'images/products/'.$path;
        }

        return array_values(array_unique(array_filter($paths)));
    }

    private static function existingAsset(string $path): ?string
    {
        $path = trim(str_replace('\\', '/', $path), '/');
        if ($path === '') {
            return null;
        }

        $optimized = self::optimizedPath($path);
        if ($optimized) {
            return asset($optimized);
        }

        return self::existsInPublic($path) ? asset($path) : null;
    }

    private static function optimizedPath(string $path): ?string
    {
        $optimized = 'optimized-cache/'.$path.'.jpg';
        return self::existsInPublic($optimized) ? $optimized : null;
    }

    private static function findByBasename(string $path): ?string
    {
        $basename = pathinfo($path, PATHINFO_BASENAME);
        if ($basename === '') {
            return null;
        }

        foreach (self::imageIndex() as $image) {
            if (strcasecmp($image['basename'], $basename) === 0) {
                return self::existingAsset($image['path']) ?: asset($image['path']);
            }
        }

        return null;
    }

    private static function fallbackFromContext(mixed $context): ?string
    {
        $data = self::contextData($context);
        $name = $data['name'] ?? '';
        $slug = $data['slug'] ?? '';
        $category = $data['category'] ?? '';
        $subcategory = $data['subcategory'] ?? '';

        $query = trim($name.' '.$slug);
        $tokens = self::tokens($query);

        $best = null;
        $bestScore = 0;

        foreach (self::imageIndex() as $image) {
            $score = 0;

            foreach ($tokens as $token) {
                if (str_contains($image['name'], $token)) {
                    $score += strlen($token) >= 5 ? 18 : 10;
                }
                if (str_contains($image['path_key'], $token)) {
                    $score += strlen($token) >= 5 ? 10 : 5;
                }
            }

            if ($category && in_array($image['dir'], self::categoryDirs($category, $subcategory), true)) {
                $score += 4;
            }

            if ($score > $bestScore) {
                $best = $image['path'];
                $bestScore = $score;
            }
        }

        if ($best && $bestScore >= 10) {
            return self::existingAsset($best) ?: asset($best);
        }

        foreach (self::categoryDefaults($category, $subcategory) as $path) {
            $asset = self::existingAsset($path);
            if ($asset) {
                return $asset;
            }
        }

        return self::existingAsset('images/brillant.png');
    }

    private static function contextData(mixed $context): array
    {
        if (is_array($context)) {
            return $context;
        }

        if (is_object($context)) {
            return [
                'name' => $context->name ?? '',
                'slug' => $context->slug ?? '',
                'category' => $context->category ?? '',
                'subcategory' => $context->subcategory ?? '',
            ];
        }

        if (is_string($context)) {
            return ['name' => $context];
        }

        return [];
    }

    private static function tokens(string $text): array
    {
        $text = self::key($text);
        $stop = array_flip([
            'tepih', 'tepiha', 'perde', 'postava', 'mbulesa', 'batanije',
            'jastek', 'jasteke', 'dekorues', 'shkallore', 'rrumbullaket',
            'moderne', 'tradicionale', 'produkt', 'oferta', 'set',
        ]);

        return array_values(array_unique(array_filter(
            preg_split('/\s+/', $text) ?: [],
            fn ($token) => strlen($token) >= 3 && !isset($stop[$token])
        )));
    }

    private static function categoryDefaults(string $category, string $subcategory = ''): array
    {
        $category = strtolower($category);
        $subcategory = strtolower($subcategory);

        if ($category === 'perde' && $subcategory === 'ditore') {
            return ['perdeditoree/perde.jpg', 'perdeditoree/image00001.jpeg'];
        }

        if ($category === 'perde') {
            return ['curtainn/SOFTPERDE.jpg', 'curtainn/raffaello.jpg'];
        }

        return match ($category) {
            'tepiha' => ['carpet/carpetmara.jpg', 'slider/otto.bmp', 'slider/tepihali600cream.png'],
            'postava' => ['postavav/beedsheet10.png', 'postavav/beedshet.png'],
            'mbulesa' => ['mbulesaa/IMG_7526.jpg', 'mbulesaa/2-2-1120x1493.jpg'],
            'batanije' => ['batanijee/IMG_7631.jpg', 'batanijee/batanije-4-1120x1493.jpg'],
            'jastekdekorues' => ['jastak/IMG_7959.jpg', 'jastak/JASTAKDEKORUES.jpg'],
            'posteqia' => ['posteqiaa/faux-1.jpg', 'posteqiaa/faux-2.jpg'],
            'tepihebanjo' => ['tepihebanjoo/crop-template-print1-1120x1493.png'],
            'garnishte' => ['images/garnishte.jpg'],
            default => ['images/brillant.png'],
        };
    }

    private static function categoryDirs(string $category, string $subcategory = ''): array
    {
        $category = strtolower($category);
        $subcategory = strtolower($subcategory);

        return match ($category) {
            'tepiha' => ['carpet', 'slider', 'optimized-cache/carpet', 'optimized-cache/slider'],
            'perde' => $subcategory === 'ditore'
                ? ['perdeditoree', 'optimized-cache/perdeditoree']
                : ['curtainn', 'optimized-cache/curtainn'],
            'postava' => ['postavav', 'optimized-cache/postavav'],
            'mbulesa' => ['mbulesaa', 'optimized-cache/mbulesaa'],
            'batanije' => ['batanijee', 'optimized-cache/batanijee'],
            'jastekdekorues' => ['jastak', 'optimized-cache/jastak'],
            'posteqia' => ['posteqiaa', 'optimized-cache/posteqiaa'],
            'tepihebanjo' => ['tepihebanjoo', 'optimized-cache/tepihebanjoo'],
            'garnishte' => ['images'],
            default => [],
        };
    }

    private static function imageIndex(): array
    {
        static $index = null;

        if ($index !== null) {
            return $index;
        }

        $index = [];
        $root = public_path();
        $files = glob($root.'/{optimized-cache,carpet,curtainn,perdeditoree,postavav,mbulesaa,batanijee,jastak,posteqiaa,tepihebanjoo,slider,images}/*.{jpg,jpeg,png,webp,bmp,JPG,JPEG,PNG,WEBP,BMP}', GLOB_BRACE) ?: [];

        foreach ($files as $file) {
            $relative = str_replace('\\', '/', ltrim(str_replace($root, '', $file), DIRECTORY_SEPARATOR));
            $basename = basename($relative);
            $name = pathinfo($basename, PATHINFO_FILENAME);

            if (preg_match('/^(llogo|logo|brillant|favicon|placeholder)/i', $name)) {
                continue;
            }

            $index[] = [
                'path' => $relative,
                'path_key' => self::key($relative),
                'name' => self::key($name),
                'basename' => $basename,
                'dir' => dirname($relative),
            ];
        }

        return $index;
    }

    private static function key(string $value): string
    {
        $value = strtolower(iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $value) ?: $value);
        $value = preg_replace('/[^a-z0-9]+/', ' ', $value) ?? '';
        return trim(preg_replace('/\s+/', ' ', $value) ?? '');
    }

    private static function existsInPublic(string $path): bool
    {
        return is_file(public_path(str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $path)));
    }
}
