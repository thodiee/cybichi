<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('client_code', 30)->unique();
            $table->string('contact_name', 120);
            $table->string('job_title', 100)->nullable();
            $table->string('company_name', 150)->nullable();
            $table->string('whatsapp_number', 25);
            $table->string('email', 150)->nullable();
            $table->string('identity_number', 50)->nullable();
            $table->text('address')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
