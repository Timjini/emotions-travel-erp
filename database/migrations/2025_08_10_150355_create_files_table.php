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
        Schema::create('files', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('customer_id');
            $table->string('reference')->unique();
            $table->string('number_of_people');
            $table->date('start_date');
            $table->date('end_date');
            $table->uuid('program_id')->nullable();
            $table->uuid('destination_id')->nullable();
            $table->uuid('currency_id')->nullable();
            $table->string('guide')->nullable();
            $table->longText('note')->nullable();
            $table->softDeletes(); 
            $table->timestamps();

            $table->foreign('customer_id')->references('id')->on('customers')->cascadeOnDelete();
            $table->foreign('program_id')->references('id')->on('programs')->nullOnDelete();
            $table->foreign('destination_id')->references('id')->on('destinations')->nullOnDelete();
            $table->foreign('currency_id')->references('id')->on('currencies')->nullOnDelete();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('files');
    }
};
