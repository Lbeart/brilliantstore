<?php

namespace App\Support;

use Illuminate\Support\Facades\Storage;

class ProductImages
{
    public static function urls(mixed $value, ?string $placeholder = null): array
    {
        $urls = [];

        foreach (self::decode($value) as $path) {
            $url = self::normalize($path);
            if ($url) {
                $urls[] = $url;
            }
        }

        if (empty($urls) && $placeholder) {
            $urls[] = $placeholder;
        }

        return array_values(array_unique($urls));
    }

    public static function url(mixed $value, ?string $placeholder = null): string
    {
        return self::urls($value, $placeholder)[0] ?? ($placeholder ?: asset('images/placeholder-product.png'));
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

    private static function normalize(string $raw): ?string
    {
        $path = trim($raw, " \t\n\r\0\x0B\"'");
        if ($path === '') {
            return null;
        }

        if (preg_match('#^https?://#i', $path)) {
            $urlPath = parse_url($path, PHP_URL_PATH);

            if (is_string($urlPath) && preg_match('#^/(storage|images|products)/#', $urlPath)) {
                $localUrl = self::normalize($urlPath);
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

            if (str_starts_with($storagePath, 'images/')) {
                return self::publicImageUrl(substr($storagePath, strlen('images/')));
            }

            return self::publicImageUrl($storagePath) ?? asset('storage/'.$storagePath);
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
            return asset($path);
        }

        return self::publicImageUrl($path)
            ?? self::storageUrl($path)
            ?? self::storageUrl('products/'.$path)
            ?? asset('images/products/'.$path);
    }

    private static function existsInPublic(string $path): bool
    {
        return is_file(public_path(str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $path)));
    }

    private static function extractImagePaths(string $raw): array
    {
        preg_match_all(
            '#(?:https?://[^\s"\']+)?/?(?:storage/)?(?:images/)?products/[^\s"\',\]]+\.(?:jpe?g|png|webp|gif|avif)#i',
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
        return self::existsInPublic($path) ? asset($path) : null;
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
}
