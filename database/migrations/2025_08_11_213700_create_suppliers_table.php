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
        Schema::create('suppliers', function (Blueprint $table) {
            $table->uuid('id')->primary();

            // Basic information
            $table->string('name');
            $table->string('invoicing_entity');

            // Contact information
            $table->string('email')->nullable();
            $table->string('contact_person')->nullable();
            $table->string('website')->nullable();

            // Address information
            $table->string('address');
            $table->string('post_code');
            $table->string('city');
            $table->string('district')->nullable();
            $table->string('country');

            // Phone numbers
            $table->string('phone_1')->nullable();
            $table->string('phone_2')->nullable();

            // Business information
            $table->string('vat_number')->nullable();
            $table->string('type');
            $table->string('category')->nullable();

            // Financial information
            $table->string('iban')->nullable();
            $table->string('swift_code')->nullable();

            // Additional fields
            $table->string('status')->default('active');
            $table->string('preferred_language')->default('en');
            $table->text('notes')->nullable();
            $table->string('source')->nullable();

            // company
            $table->uuid('company_id');
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');

            // Tracking
            $table->uuid('created_by');
            $table->foreign('created_by', 'fk_suppliers_created_by_users')
                ->references('id')
                ->on('users');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('suppliers');
    }
};
