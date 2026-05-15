<?php

namespace App\Support;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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

        if (empty($urls) && $context) {
            $urls = self::contextFallbackUrls($context);
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

        if (self::isPlaceholderPath($raw)) {
            return [];
        }

        if (preg_match('/\[[^\]]+\]/', $raw, $match)) {
            $raw = $match[0];
        }

        $decoded = json_decode($raw, true);
        if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
            return array_values(array_filter($decoded));
        }

        $extracted = self::extractImagePaths($raw);
        if (!empty($extracted)) {
            return $extracted;
        }

        if (str_contains($raw, ',')) {
            $parts = array_map(
                fn ($part) => trim($part, " \t\n\r\0\x0B\"'[]"),
                explode(',', $raw)
            );

            $parts = array_values(array_filter($parts));
            if (!empty($parts)) {
                return $parts;
            }
        }

        return [$raw];
    }

    private static function normalize(string $raw, mixed $context = null): ?string
    {
        $path = trim($raw, " \t\n\r\0\x0B\"'");
        if ($path === '' || self::isPlaceholderPath($path)) {
            return null;
        }

        if (preg_match('#^https?://#i', $path)) {
            $urlPath = parse_url($path, PHP_URL_PATH);

            if (is_string($urlPath) && self::looksLocalPath($urlPath)) {
                $localUrl = self::normalize($urlPath, $context);
                if ($localUrl) {
                    return $localUrl;
                }
            }

            return $path;
        }

        $path = str_replace('\\', '/', ltrim($path, '/'));
        $path = preg_replace('#^public/#', '', $path);

        if ($path === '') {
            return null;
        }

        if (str_starts_with($path, 'storage/')) {
            $storagePath = preg_replace('#^storage/#', '', $path);
            if (self::existsInStorage($storagePath)) {
                return Storage::disk('public')->url($storagePath);
            }

            if (self::existsInPublic($storagePath)) {
                return self::publicPathUrl($storagePath);
            }

            if (str_starts_with($storagePath, 'images/')) {
                return self::publicImageUrl(substr($storagePath, strlen('images/')));
            }

            return self::legacyPublicUrl($storagePath, $context)
                ?? self::publicImageUrl($storagePath)
                ?? asset('storage/'.$storagePath);
        }

        if (str_starts_with($path, 'images/products/')) {
            $productPath = substr($path, strlen('images/'));

            return self::publicPathUrl($path)
                ?? self::storageUrl($productPath)
                ?? asset($path);
        }

        if (str_starts_with($path, 'images/')) {
            return self::publicPathUrl($path) ?? asset($path);
        }

        if (str_starts_with($path, 'products/')) {
            return self::publicPathUrl('images/'.$path)
                ?? self::storageUrl($path)
                ?? asset('images/'.$path);
        }

        if (self::existsInPublic($path)) {
            return self::publicPathUrl($path);
        }

        return self::legacyPublicUrl($path, $context)
            ?? self::publicImageUrl($path)
            ?? self::storageUrl($path)
            ?? self::storageUrl('products/'.$path)
            ?? asset('images/products/'.$path);
    }

    private static function existsInPublic(string $path): bool
    {
        return is_file(public_path(str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $path)));
    }

    private static function isPlaceholderPath(string $path): bool
    {
        $path = strtolower(str_replace('\\', '/', $path));

        return str_contains($path, 'placeholder')
            || str_contains($path, 'llogo.png')
            || str_contains($path, 'brillant.png');
    }

    private static function looksLocalPath(string $path): bool
    {
        $path = ltrim(str_replace('\\', '/', $path), '/');
        $first = strtok($path, '/');

        return in_array($first, array_merge(['storage', 'images', 'products'], self::allLegacyFolders()), true);
    }

    private static function extractImagePaths(string $raw): array
    {
        preg_match_all(
            '#(?:https?://[^\s"\']+)?/?(?:storage/)?(?:images/)?[a-z0-9_-]*/?[^\s"\',\]]+\.(?:jpe?g|png|webp|gif|avif|bmp)#i',
            $raw,
            $matches
        );

        if (empty($matches[0])) {
            return [];
        }

        return array_values(array_unique(array_map(
            fn ($path) => trim($path, " \t\n\r\0\x0B\"'"),
            $matches[0]
        )));
    }

    private static function existsInStorage(string $path): bool
    {
        return Storage::disk('public')->exists(str_replace('\\', '/', $path));
    }

    private static function publicPathUrl(string $path): ?string
    {
        $path = ltrim(str_replace('\\', '/', $path), '/');
        $mobileSafe = self::mobileSafePublicPath($path);

        return self::existsInPublic($mobileSafe) ? asset($mobileSafe) : null;
    }

    private static function publicImageUrl(string $path): ?string
    {
        $path = ltrim(str_replace('\\', '/', $path), '/');

        return self::publicPathUrl('images/'.$path);
    }

    private static function storageUrl(string $path): ?string
    {
        $path = ltrim(str_replace('\\', '/', $path), '/');

        return self::existsInStorage($path) ? Storage::disk('public')->url($path) : null;
    }

    private static function legacyPublicUrl(string $path, mixed $context = null): ?string
    {
        $path = ltrim(str_replace('\\', '/', $path), '/');
        $filename = basename($path);
        $candidatePaths = [];

        foreach (self::legacyFolders($context) as $folder) {
            $candidatePaths[] = $folder.'/'.$path;
            $candidatePaths[] = $folder.'/'.$filename;
        }

        foreach (self::allLegacyFolders() as $folder) {
            $candidatePaths[] = $folder.'/'.$path;
            $candidatePaths[] = $folder.'/'.$filename;
        }

        foreach (array_unique($candidatePaths) as $candidate) {
            $url = self::publicPathUrl($candidate);
            if ($url) {
                return $url;
            }
        }

        return null;
    }

    private static function contextFallbackUrls(mixed $context): array
    {
        $name = (string) data_get($context, 'name', '');
        $tokens = self::nameTokens($name);

        if (empty($tokens)) {
            return [];
        }

        $matches = [];

        foreach (self::legacyFolders($context) ?: self::allLegacyFolders() as $folder) {
            $dir = public_path(str_replace('/', DIRECTORY_SEPARATOR, $folder));
            if (!is_dir($dir)) {
                continue;
            }

            foreach (glob($dir.DIRECTORY_SEPARATOR.'*') ?: [] as $file) {
                if (!is_file($file) || !preg_match('/\.(jpe?g|png|webp|gif|avif|bmp)$/i', $file)) {
                    continue;
                }

                $filename = basename($file);
                $path = $folder.'/'.$filename;
                $score = self::filenameScore($filename, $tokens, $name);

                if ($score > 0) {
                    $safePath = self::mobileSafePublicPath($path);
                    $matches[$safePath] = max($matches[$safePath] ?? 0, $score);
                }
            }
        }

        arsort($matches);

        return array_values(array_map(fn ($path) => asset($path), array_keys(array_slice($matches, 0, 4, true))));
    }

    private static function nameTokens(string $name): array
    {
        $name = strtolower(Str::ascii($name));
        $name = preg_replace('/[^a-z0-9]+/', ' ', $name) ?? '';

        $stopWords = [
            'tepih', 'tepiha', 'tepihe', 'tapet', 'tapeta', 'perde', 'postava',
            'mbulesa', 'batanije', 'jastek', 'dekorues', 'posteqia', 'garnishte',
            'modern', 'antibakterial', 'cm', 'euro',
        ];

        $tokens = array_filter(
            explode(' ', $name),
            fn ($token) => strlen($token) >= 3 && !in_array($token, $stopWords, true)
        );

        return array_values(array_unique($tokens));
    }

    private static function filenameScore(string $filename, array $tokens, string $productName): int
    {
        $base = pathinfo($filename, PATHINFO_FILENAME);
        $haystack = strtolower(Str::ascii($base));
        $compactHaystack = preg_replace('/[^a-z0-9]+/', '', $haystack) ?? '';
        $productSlug = preg_replace('/[^a-z0-9]+/', '', strtolower(Str::ascii($productName))) ?? '';

        $score = 0;

        foreach ($tokens as $token) {
            if (str_contains($haystack, $token) || str_contains($compactHaystack, $token)) {
                $score += strlen($token) >= 5 ? 12 : 8;
            }
        }

        if ($compactHaystack !== '' && $productSlug !== '' && str_contains($productSlug, $compactHaystack)) {
            $score += 20;
        }

        return $score;
    }

    private static function legacyFolders(mixed $context = null): array
    {
        $category = strtolower((string) data_get($context, 'category', ''));
        $subcategory = strtolower((string) data_get($context, 'subcategory', ''));

        return match ($category) {
            'tepiha' => ['carpet'],
            'perde' => $subcategory === 'ditore' ? ['perdeditoree', 'curtainn'] : ['curtainn', 'perdeditoree'],
            'postava' => ['postavav'],
            'mbulesa' => ['mbulesaa'],
            'jastekdekorues' => ['jastak'],
            'batanije' => ['batanijee'],
            'tepihebanjo' => ['tepihebanjoo'],
            'posteqia' => ['posteqiaa'],
            default => [],
        };
    }

    private static function allLegacyFolders(): array
    {
        return [
            'carpet',
            'curtainn',
            'perdeditoree',
            'postavav',
            'mbulesaa',
            'jastak',
            'batanijee',
            'tepihebanjoo',
            'posteqiaa',
            'slider',
        ];
    }

    private static function mobileSafePublicPath(string $path): string
    {
        if (!preg_match('/\.bmp$/i', $path)) {
            return $path;
        }

        $jpgPath = preg_replace('/\.bmp$/i', '.jpg', $path);

        return $jpgPath && self::existsInPublic($jpgPath) ? $jpgPath : $path;
    }
}
