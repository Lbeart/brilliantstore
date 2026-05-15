<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;

class LegacyImageController extends Controller
{
    public function show(string $encoded): Response
    {
        $path = $this->decodePath($encoded);
        abort_if(!$path || !$this->isAllowedPath($path), 404);

        $fullPath = public_path(str_replace('/', DIRECTORY_SEPARATOR, $path));
        abort_unless(is_file($fullPath), 404);

        if (preg_match('/\.bmp$/i', $path)) {
            return $this->bmpAsJpeg($fullPath);
        }

        return response(file_get_contents($fullPath), 200, [
            'Content-Type' => mime_content_type($fullPath) ?: 'image/jpeg',
            'Cache-Control' => 'public, max-age=31536000, immutable',
        ]);
    }

    private function decodePath(string $encoded): ?string
    {
        $encoded = strtr($encoded, '-_', '+/');
        $encoded .= str_repeat('=', (4 - strlen($encoded) % 4) % 4);

        $decoded = base64_decode($encoded, true);
        if (!is_string($decoded) || $decoded === '') {
            return null;
        }

        return ltrim(str_replace('\\', '/', $decoded), '/');
    }

    private function isAllowedPath(string $path): bool
    {
        if (str_contains($path, '..')) {
            return false;
        }

        $first = strtok($path, '/');

        return in_array($first, [
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
        ], true);
    }

    private function bmpAsJpeg(string $fullPath): Response
    {
        abort_unless(function_exists('imagecreatefrombmp') && function_exists('imagejpeg'), 404);

        $image = @imagecreatefrombmp($fullPath);
        abort_unless($image, 404);

        ob_start();
        imagejpeg($image, null, 88);
        imagedestroy($image);
        $jpeg = ob_get_clean();

        abort_unless(is_string($jpeg), 404);

        return response($jpeg, 200, [
            'Content-Type' => 'image/jpeg',
            'Cache-Control' => 'public, max-age=31536000, immutable',
        ]);
    }
}
