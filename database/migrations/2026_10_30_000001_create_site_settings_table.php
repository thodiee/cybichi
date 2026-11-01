<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('site_settings', function (Blueprint $table) {
            $table->id();
            $table->string('setting_group', 50); // 'general', 'hero', 'contact', 'seo', 'billing_legal', 'sections'
            $table->string('setting_key', 100)->unique();
            $table->longText('setting_value')->nullable();
            $table->string('setting_type', 30)->default('text'); // 'text', 'textarea', 'json', 'image', 'boolean'
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('updated_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('site_settings');
    }
};
