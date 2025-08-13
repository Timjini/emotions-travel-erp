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

        Schema::create('companies', function (Blueprint $table) {
            $table->uuid('id')->primary();

            // Basic information
            $table->string('name');
            $table->string('legal_name')->nullable(); // corresponds to "Legal Name" field
            $table->string('logo_path')->nullable();  // for uploaded company logo
            $table->string('type');                   // company type
            $table->string('invoicing_entity')->nullable(); // optional invoicing entity

            // Contact information
            $table->string('email')->nullable();
            $table->string('contact_person')->nullable();
            $table->string('website')->nullable();
            $table->string('phone_1')->nullable();
            $table->string('phone_2')->nullable();

            // Address information
            $table->string('address');
            $table->string('post_code');
            $table->string('city');
            $table->string('district')->nullable();
            $table->string('country');

            // Business information
            $table->string('vat_number')->nullable();

            // Financial information
            $table->string('iban')->nullable();
            $table->string('swift_code')->nullable();

            // Additional fields
            $table->string('status')->default('active');
            $table->string('preferred_language')->default('en');
            $table->text('notes')->nullable();
            $table->string('source')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
