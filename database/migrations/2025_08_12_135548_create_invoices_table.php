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
        Schema::create('invoices', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('file_id');
            $table->uuid('proforma_id')->nullable();
            $table->string('invoice_number')->unique();
            $table->date('issue_date');
            $table->date('due_date')->nullable();
            $table->decimal('total_amount', 10, 2);
            $table->uuid('currency_id')->nullable();
            $table->string('status', 20)->default('unpaid');
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->foreign('file_id')->references('id')->on('files')->cascadeOnDelete();
            $table->foreign('proforma_id')->references('id')->on('proformas')->nullOnDelete();
            $table->foreign('currency_id')->references('id')->on('currencies')->nullOnDelete();

            // company
            $table->uuid('company_id');
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');

            // Tracking
            $table->uuid('created_by');
            $table->foreign('created_by', 'fk_invoices_created_by_users')
                ->references('id')
                ->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
