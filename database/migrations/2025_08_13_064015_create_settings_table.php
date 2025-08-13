<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('company_id');

            // Financial/Banking
            $table->string('iban')->nullable();
            $table->string('swift_code')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('bank_account_name')->nullable();

            // Localization
            $table->string('preferred_language')->default('en');
            $table->string('timezone')->default('UTC');
            $table->string('date_format')->default('Y-m-d');
            $table->string('financial_year_start')->default('01-01');

            // Invoicing
            $table->string('invoice_prefix')->default('INV-');
            $table->integer('invoice_start_number')->default(1);
            $table->integer('invoice_due_days')->default(30);
            $table->string('invoice_currency')->default('EUR');

            // Additional contact
            $table->string('contact_person')->nullable();
            $table->string('phone_2')->nullable();
            $table->string('website')->nullable();
            $table->string('district')->nullable();

            // Metadata
            $table->text('notes')->nullable();
            $table->string('source')->nullable();

            // Relations
            $table->foreign('company_id')->references('id')->on('companies')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
