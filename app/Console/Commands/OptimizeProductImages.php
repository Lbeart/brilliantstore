<?php

namespace App\Console\Commands;

use App\Models\Product;
use App\Support\ProductImages;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Intervention\Image\Facades\Image;

class OptimizeProductImages extends Command
{
    protected $signature = 'products:optimize-images {--force : Recreate cache files even when they already exist}';

    protected $description = 'Create lightweight cached copies for product images.';

    public function handle(): int
    {
        if (!$this->canOptimizeImages()) {
            $this->warn('Image optimization needs the PHP GD or Imagick extension.');

            return self::FAILURE;
        }

        $paths = $this->collectProductImagePaths();
        $created = 0;
        $skipped = 0;
        $failed = 0;

        foreach ($paths as $relativePath) {
            $sourcePath = public_path(str_replace('/', DIRECTORY_SEPARATOR, $relativePath));
            $cachePath = $this->cachePath($relativePath);

            if (
                !$this->option('force')
                && is_file($cachePath)
                && filemtime($cachePath) >= filemtime($sourcePath)
            ) {
                $skipped++;
                continue;
            }

            $this->ensureDirectory(dirname($cachePath));

            try {
                Image::make($sourcePath)
                    ->orientate()
                    ->resize(1100, 1100, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    })
                    ->encode('jpg', 76)
                    ->save($cachePath);

                $created++;
            } catch (\Throwable $e) {
                $failed++;
                $this->warn('Failed: '.$relativePath.' ('.$e->getMessage().')');
            }
        }

        $this->info("Optimization finished. Created: {$created}, skipped: {$skipped}, failed: {$failed}.");

        return $failed > 0 ? self::FAILURE : self::SUCCESS;
    }

    private function collectProductImagePaths(): array
    {
        $paths = [];

        try {
            Product::query()
                ->select(['id', 'image_path', 'color_variants', 'category', 'subcategory'])
                ->where(function ($query) {
                    $query->whereNotNull('image_path')->orWhereNotNull('color_variants');
                })
                ->cursor()
                ->each(function (Product $product) use (&$paths) {
                foreach (ProductImages::decode($product->image_path) as $imagePath) {
                    $relativePath = $this->publicRelativePath($imagePath, $product);
                    if ($relativePath) {
                        $paths[] = $relativePath;
                    }
                }

                $variants = is_array($product->color_variants)
                    ? $product->color_variants
                    : (json_decode((string) $product->color_variants, true) ?: []);

                foreach ($variants as $variant) {
                    foreach (ProductImages::decode($variant['image_paths'] ?? ($variant['image_path'] ?? null)) as $imagePath) {
                        $relativePath = $this->publicRelativePath($imagePath, $product);
                        if ($relativePath) {
                            $paths[] = $relativePath;
                        }
                    }
                }
                });
        } catch (\Throwable $exception) {
            $this->warn('Database unavailable; optimizing images found in public folders.');
            Log::notice('Product image optimizer continued without database.', [
                'exception_class' => $exception::class,
            ]);
        }

        $publicFolders = [
            'images/products', 'carpet', 'curtainn', 'perdeditoree', 'postavav',
            'mbulesaa', 'jastak', 'batanijee', 'tepihebanjoo', 'posteqiaa',
        ];

        foreach ($publicFolders as $relativeFolder) {
            $productFolder = public_path($relativeFolder);
            if (!is_dir($productFolder)) {
                continue;
            }

            $iterator = new \RecursiveIteratorIterator(
                new \RecursiveDirectoryIterator($productFolder, \FilesystemIterator::SKIP_DOTS)
            );

            foreach ($iterator as $file) {
                if (!$file->isFile() || !$this->isSupportedImage($file->getPathname())) {
                    continue;
                }

                $paths[] = $relativeFolder.'/'.str_replace('\\', '/', substr($file->getPathname(), strlen($productFolder) + 1));
            }
        }

        return array_values(array_unique($paths));
    }

    private function publicRelativePath(string $raw, ?Product $product = null): ?string
    {
        $path = trim($raw, " \t\n\r\0\x0B\"'");
        if ($path === '') {
            return null;
        }

        if (preg_match('#^https?://#i', $path)) {
            $path = parse_url($path, PHP_URL_PATH) ?: $path;
        }

        $path = str_replace('\\', '/', ltrim($path, '/'));
        $path = preg_replace('#^public/#', '', $path);

        foreach (array_unique([
            $path,
            str_starts_with($path, 'products/') ? 'images/'.$path : null,
            str_starts_with($path, 'storage/images/') ? substr($path, strlen('storage/')) : null,
        ]) as $candidate) {
            if (!is_string($candidate) || !$this->isSupportedImage($candidate)) {
                continue;
            }

            if (is_file(public_path(str_replace('/', DIRECTORY_SEPARATOR, $candidate)))) {
                return $candidate;
            }
        }

        $resolvedUrl = ProductImages::url($raw, null, $product);
        $resolvedPath = ltrim((string) parse_url($resolvedUrl, PHP_URL_PATH), '/');
        if (!str_contains($resolvedPath, 'placeholder') && $this->isSupportedImage($resolvedPath)) {
            if (str_starts_with($resolvedPath, 'optimized-cache/')) {
                $resolvedPath = preg_replace('#^optimized-cache/#', '', $resolvedPath);
                $resolvedPath = preg_replace('/\.jpg$/i', '', $resolvedPath);
            }

            if (is_file(public_path(str_replace('/', DIRECTORY_SEPARATOR, $resolvedPath)))) {
                return $resolvedPath;
            }
        }

        return null;
    }

    private function cachePath(string $relativePath): string
    {
        return public_path(
            'optimized-cache/' . str_replace(['/', '\\'], DIRECTORY_SEPARATOR, ltrim($relativePath, '/')) . '.jpg'
        );
    }

    private function isSupportedImage(string $path): bool
    {
        return (bool) preg_match('/\.(jpe?g|png|webp|bmp)$/i', $path);
    }

    private function canOptimizeImages(): bool
    {
        return extension_loaded('gd') || extension_loaded('imagick');
    }

    private function ensureDirectory(string $path): void
    {
        if (!is_dir($path)) {
            mkdir($path, 0777, true);
        }
    }
}
