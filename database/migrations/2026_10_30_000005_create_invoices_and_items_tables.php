<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('invoice_number', 50)->unique();
            $table->foreignId('client_id')->constrained('clients')->restrictOnDelete();
            $table->foreignId('product_id')->nullable()->constrained('products')->nullOnDelete();
            $table->string('project_title', 200);
            $table->string('billing_type', 40)->default('one_time'); // 'one_time', 'down_payment', 'milestone_termin', 'final_settlement', 'recurring'
            $table->date('issue_date');
            $table->date('due_date');

            // Amount breakdown
            $table->decimal('subtotal', 15, 2)->default(0.00);
            $table->decimal('discount_amount', 15, 2)->default(0.00);
            $table->decimal('tax_percentage', 5, 2)->default(0.00);
            $table->decimal('tax_amount', 15, 2)->default(0.00);
            $table->decimal('grand_total', 15, 2)->default(0.00);
            $table->decimal('amount_paid', 15, 2)->default(0.00);
            $table->decimal('balance_due', 15, 2)->default(0.00);

            $table->string('payment_status', 30)->default('unpaid'); // 'draft', 'unpaid', 'partial_dp', 'paid', 'overdue', 'cancelled'
            $table->timestamp('paid_at')->nullable();
            $table->text('payment_method_info')->nullable();
            $table->text('admin_notes')->nullable();
            $table->string('verification_hash', 64)->unique();
            $table->foreignId('created_by')->constrained('users')->restrictOnDelete();
            $table->timestamps();
        });

        Schema::create('invoice_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('invoice_id')->constrained('invoices')->cascadeOnDelete();
            $table->string('item_name', 200);
            $table->text('item_description')->nullable();
            $table->decimal('quantity', 10, 2)->default(1.00);
            $table->string('unit_name', 30)->default('Paket');
            $table->decimal('unit_price', 15, 2);
            $table->decimal('total_price', 15, 2);
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('invoice_items');
        Schema::dropIfExists('invoices');
    }
};
