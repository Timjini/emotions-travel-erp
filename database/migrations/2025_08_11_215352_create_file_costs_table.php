<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
       Schema::create('file_costs', function (Blueprint $table) {
            // Primary Key
            $table->uuid('id')->primary();

            // Relationships
            $table->foreignUuid('file_id')->constrained('files')->cascadeOnDelete();
            $table->foreignUuid('customer_id')->constrained('customers')->cascadeOnDelete();
            $table->foreignUuid('supplier_id')->nullable()->constrained('suppliers')->nullOnDelete();
            $table->foreignUuid('file_item_id')->nullable()->constrained('file_items')->nullOnDelete();
            
            // Currency Relationships - UPDATED
            $table->uuid('original_currency_id')->nullable();
            $table->foreign('original_currency_id')->references('id')->on('currencies')->nullOnDelete();
            
            $table->uuid('base_currency_id')->nullable();
            $table->foreign('base_currency_id')->references('id')->on('currencies')->nullOnDelete();

            // Cost Details
            $table->string('service_type');
            $table->text('description')->nullable();
            $table->unsignedInteger('quantity')->default(1);
            $table->decimal('unit_price', 12, 2);
            $table->decimal('total_price', 12, 2);
            $table->decimal('exchange_rate', 12, 6)->default(1);
            $table->decimal('converted_total', 12, 2);

            // Payment Status
            $table->string('payment_status')->default('pending');
            $table->decimal('amount_paid', 12, 2)->default(0);
            $table->date('payment_date')->nullable();

            // Operational Details
            $table->unsignedInteger('number_of_people')->nullable();
            $table->boolean('quantity_anomaly')->default(false);
            $table->date('service_date');

            // Metadata
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();

            // Company
            $table->uuid('company_id')->nullable();
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');

            // Tracking
            $table->uuid('created_by');
            $table->foreign('created_by', 'fk_file_costs_created_by_users')
                ->references('id')
                ->on('users');

            // Indexes
            $table->index(['file_id', 'customer_id']);
            $table->index(['supplier_id', 'service_date']);
            $table->index('payment_status');
        });
    }

    public function down()
    {
        Schema::dropIfExists('file_costs');
    }
};
