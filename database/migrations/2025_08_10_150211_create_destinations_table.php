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
        Schema::create('destinations', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('code')->nullable();
            $table->string('name');
            $table->string('city')->nullable();
            $table->string('region')->nullable();
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->string('timezone')->nullable();
            $table->string('airport_code', 3)->nullable();
            $table->uuid('currency_id')->nullable();
            $table->foreign('currency_id')->references('id')->on('currencies')->nullOnDelete();
            $table->boolean('visa_required')->default(false);
            $table->string('best_season')->nullable();
            $table->string('average_temperature')->nullable();
            $table->text('description')->nullable();
            $table->string('thumbnail_url')->nullable();
            $table->json('gallery')->nullable();
            $table->decimal('default_markup', 5, 2)->nullable();
            $table->date('active_from')->nullable();
            $table->date('active_until')->nullable();
            $table->boolean('is_active')->default(true);
            $table->uuid('company_id');
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            $table->uuid('country_id');
            $table->foreign('country_id')->references('id')->on('countries')->onDelete('cascade');
            $table->uuid('created_by');
            $table->foreign('created_by', 'fk_destinations_created_by_users')
                ->references('id')
                ->on('users');
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('destinations');
    }
};
