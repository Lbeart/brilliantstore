<?php

namespace App\Support;

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

        return [$raw];
    }

    private static function normalize(string $raw): ?string
    {
        $path = trim($raw, " \t\n\r\0\x0B\"'");
        if ($path === '') {
            return null;
        }

        if (preg_match('#^https?://#i', $path)) {
            if (str_contains($path, '/storage/images/')) {
                return str_replace('/storage/images/', '/images/', $path);
            }

            if (str_contains($path, '/storage/products/')) {
                return str_replace('/storage/products/', '/images/products/', $path);
            }

            return $path;
        }

        $path = ltrim($path, '/');
        $path = preg_replace('#^(public|storage)/#', '', $path);

        if ($path === '') {
            return null;
        }

        if (str_starts_with($path, 'products/')) {
            return asset('images/'.$path);
        }

        if (str_starts_with($path, 'images/') || self::existsInPublic($path)) {
            return asset($path);
        }

        if (self::existsInPublic('images/'.$path)) {
            return asset('images/'.$path);
        }

        return asset('images/products/'.$path);
    }

    private static function existsInPublic(string $path): bool
    {
        return is_file(public_path(str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $path)));
    }
}
