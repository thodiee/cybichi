<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('agreements', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('agreement_number', 50)->unique();
            $table->foreignId('client_id')->constrained('clients')->restrictOnDelete();
            $table->foreignId('product_id')->nullable()->constrained('products')->nullOnDelete();
            $table->foreignId('invoice_id')->nullable()->constrained('invoices')->nullOnDelete();
            $table->string('template_type', 50); // 'software_installation', 'custom_development', 'internet_network_contract', 'it_maintenance'
            $table->string('project_name', 200);
            $table->date('agreement_date');
            $table->date('start_date');
            $table->date('estimated_completion_date')->nullable();
            $table->unsignedInteger('warranty_period_months')->default(3);

            $table->decimal('contract_value', 15, 2);
            $table->text('payment_terms_summary');
            $table->longText('scope_of_work');
            $table->longText('agreement_clauses_html');

            $table->string('status', 30)->default('issued'); // 'draft', 'issued', 'signed_active', 'completed', 'terminated'
            $table->string('verification_hash', 64)->unique();
            $table->foreignId('created_by')->constrained('users')->restrictOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('agreements');
    }
};
