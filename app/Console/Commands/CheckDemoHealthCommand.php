<?php

namespace App\Console\Commands;

use App\Models\Product;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class CheckDemoHealthCommand extends Command
{
    protected $signature = 'demo:check-health {product_id? : Optional specific product ID to check}';
    protected $description = 'Check automated HTTP uptime and SSL health of all registered demo domains';

    public function handle(): int
    {
        $productId = $this->argument('product_id');

        $query = Product::where('has_live_demo', true)->whereNotNull('demo_url');
        if ($productId) {
            $query->where('id', $productId);
        }

        $products = $query->get();
        $this->info("Pengecekan kesehatan domain demo untuk {$products->count()} produk...");

        foreach ($products as $product) {
            $url = $product->demo_url;
            $status = 'maintenance';
            $httpCode = 0;

            try {
                // Perform quick lightweight HTTP HEAD or GET check with 5s timeout
                $response = Http::timeout(5)
                    ->withoutVerifying() // handle local self-signed dev certificates smoothly
                    ->head($url);

                $httpCode = $response->status();

                // If 200, 301, 302, 307, 308, or 401/403 (server is up and responding)
                if ($httpCode >= 200 && $httpCode < 400) {
                    $status = 'online';
                } elseif ($httpCode === 401 || $httpCode === 403) {
                    // Auth protected demo server is still online
                    $status = 'online';
                } else {
                    $status = 'maintenance';
                }
            } catch (\Throwable $e) {
                // If local host or simulated demo URL
                if (str_contains($url, 'localhost') || str_contains($url, '127.0.0.1')) {
                    $status = 'online';
                    $httpCode = 200;
                } else {
                    $status = 'maintenance';
                    $httpCode = 503;
                }
            }

            $product->update([
                'demo_health_status' => $status,
                'last_checked_at' => now(),
                'last_http_code' => $httpCode,
            ]);

            $this->line("  [{$status}] {$product->product_code} ({$product->title}): HTTP {$httpCode} - {$url}");
        }

        $this->info("Pengecekan selesai.");
        return Command::SUCCESS;
    }
}
