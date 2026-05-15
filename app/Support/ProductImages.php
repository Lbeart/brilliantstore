<?php

namespace App\Support;

use Illuminate\Support\Facades\Storage;

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

    public static function isResolvable(string $raw): bool
    {
        $path = trim($raw, " \t\n\r\0\x0B\"'");
        if ($path === '' || self::isPlaceholderPath($path)) {
            return false;
        }

        if (preg_match('#^https?://#i', $path)) {
            $urlPath = parse_url($path, PHP_URL_PATH);
            if (!is_string($urlPath) || !self::looksLocalPath($urlPath)) {
                return true;
            }

            $path = $urlPath;
        }

        $path = str_replace('\\', '/', ltrim($path, '/'));
        $path = preg_replace('#^public/#', '', $path);

        if (str_starts_with($path, 'storage/')) {
            $storagePath = preg_replace('#^storage/#', '', $path);

            return self::existsInStorage($storagePath)
                || self::existsInPublic($storagePath)
                || (str_starts_with($storagePath, 'images/') && self::existsInPublic(substr($storagePath, strlen('images/'))));
        }

        if (str_starts_with($path, 'images/products/')) {
            return self::existsInPublic($path)
                || self::existsInStorage(substr($path, strlen('images/')));
        }

        if (str_starts_with($path, 'images/')) {
            return self::existsInPublic($path);
        }

        if (str_starts_with($path, 'products/')) {
            return self::existsInPublic('images/'.$path)
                || self::existsInStorage($path);
        }

        return self::existsInPublic($path)
            || self::existsInPublic('images/'.$path)
            || self::existsInStorage($path)
            || self::existsInStorage('products/'.$path);
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
                return self::normalize($urlPath, $context);
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
                ?? self::publicImageUrl($storagePath);
        }

        if (str_starts_with($path, 'images/products/')) {
            $productPath = substr($path, strlen('images/'));

            return self::publicPathUrl($path)
                ?? self::storageUrl($productPath);
        }

        if (str_starts_with($path, 'images/')) {
            return self::publicPathUrl($path);
        }

        if (str_starts_with($path, 'products/')) {
            return self::publicPathUrl('images/'.$path)
                ?? self::storageUrl($path);
        }

        if (self::existsInPublic($path)) {
            return self::publicPathUrl($path);
        }

        return self::legacyPublicUrl($path, $context)
            ?? self::publicImageUrl($path)
            ?? self::storageUrl($path)
            ?? self::storageUrl('products/'.$path);
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

        if (preg_match('/\.bmp$/i', $path)) {
            $jpgPath = preg_replace('/\.bmp$/i', '.jpg', $path);
            if ($jpgPath && self::existsInPublic($jpgPath)) {
                return asset($jpgPath);
            }

            return self::existsInPublic($path) ? self::legacyImageUrl($path) : null;
        }

        $mobileSafe = self::mobileSafePublicPath($path);

        if (self::existsInPublic($mobileSafe)) {
            return asset($mobileSafe);
        }

        return null;
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

    private static function legacyImageUrl(string $path): string
    {
        $encoded = rtrim(strtr(base64_encode($path), '+/', '-_'), '=');

        return url('/legacy-image/'.$encoded);
    }
}
