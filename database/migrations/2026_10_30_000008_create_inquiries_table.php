<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inquiries', function (Blueprint $table) {
            $table->id();
            $table->string('inquiry_code', 30)->unique();
            $table->string('client_name', 100);
            $table->string('company_name', 100)->nullable();
            $table->string('whatsapp_number', 25);
            $table->string('email', 150)->nullable();
            $table->string('interested_category', 100)->nullable();
            $table->foreignId('referenced_product_id')->nullable()->constrained('products')->nullOnDelete();
            $table->text('project_brief');
            $table->string('status', 40)->default('new'); // 'new', 'contacted', 'negotiation', 'converted_to_invoice', 'archived'
            $table->foreignId('converted_invoice_id')->nullable()->constrained('invoices')->nullOnDelete();
            $table->string('ip_address', 45)->nullable();
            $table->text('admin_notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inquiries');
    }
};
