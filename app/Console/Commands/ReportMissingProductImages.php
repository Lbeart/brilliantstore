<?php

namespace App\Console\Commands;

use App\Models\Product;
use App\Support\ProductImages;
use Illuminate\Console\Command;

class ReportMissingProductImages extends Command
{
    protected $signature = 'products:missing-images';

    protected $description = 'List active products whose saved product image paths do not resolve to real local files.';

    public function handle(): int
    {
        $count = 0;

        Product::query()
            ->where('is_active', 1)
            ->orderByDesc('id')
            ->chunkById(100, function ($products) use (&$count) {
                foreach ($products as $product) {
                    $paths = ProductImages::decode($product->image_path);

                    if (empty($paths)) {
                        $this->line($this->formatRow($product, 'EMPTY'));
                        $count++;
                        continue;
                    }

                    foreach ($paths as $path) {
                        if (!ProductImages::isResolvable($path)) {
                            $this->line($this->formatRow($product, $path));
                            $count++;
                        }
                    }
                }
            });

        if ($count === 0) {
            $this->info('All active product image paths resolve.');
        } else {
            $this->warn($count.' missing/unresolvable product image path(s) found.');
        }

        return self::SUCCESS;
    }

    private function formatRow(Product $product, string $path): string
    {
        return implode(' | ', [
            'ID '.$product->id,
            $product->name,
            $product->slug,
            $product->category,
            $path,
        ]);
    }
}
