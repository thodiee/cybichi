<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained('service_categories')->restrictOnDelete();
            $table->string('product_code', 30)->unique();
            $table->string('title', 150);
            $table->string('slug', 150)->unique();
            $table->string('client_or_industry', 100)->nullable();
            $table->decimal('base_price', 15, 2)->nullable();
            $table->string('short_summary', 255);
            $table->longText('full_description')->nullable();
            $table->json('key_features')->nullable();
            $table->json('tech_stack')->nullable();
            $table->string('thumbnail_path', 255);
            $table->json('gallery_images')->nullable();

            // Direct demo settings & credentials
            $table->boolean('has_live_demo')->default(true);
            $table->string('demo_url', 500)->nullable();
            $table->text('demo_usage_guide')->nullable();
            $table->json('demo_credentials')->nullable();
            $table->boolean('show_credentials_publicly')->default(true);
            $table->string('demo_reset_notice', 150)->nullable();

            // Automated health status
            $table->string('demo_health_status', 30)->default('online'); // 'online', 'maintenance', 'offline'
            $table->timestamp('last_checked_at')->nullable();
            $table->unsignedSmallInteger('last_http_code')->nullable();

            // Metrics & visibility
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_active')->default(true);
            $table->unsignedBigInteger('view_count')->default(0);
            $table->unsignedBigInteger('demo_click_count')->default(0);
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
