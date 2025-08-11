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
            
            // Cost Details
            $table->string('service_type'); // e.g., transport, management
            $table->text('description')->nullable();
            $table->unsignedInteger('quantity')->default(1);
            $table->decimal('unit_price', 12, 2);
            $table->decimal('total_price', 12, 2);
            $table->string('original_currency', 3); // 3-letter ISO code
            $table->decimal('exchange_rate', 12, 6)->default(1);
            $table->string('base_currency', 3)->default('EUR');
            $table->decimal('converted_total', 12, 2); // Total in base currency
            
            // Payment Status (using string instead of enum)
            $table->string('payment_status')->default('pending');
            $table->decimal('amount_paid', 12, 2)->default(0);
            $table->date('payment_date')->nullable();
            
            // Operational Details
            $table->unsignedInteger('number_of_people')->nullable();
            $table->boolean('quantity_anomaly')->default(false);
            $table->date('service_date');
            
            // Metadata
            $table->text('notes')->nullable();
            $table->foreignUuid('created_by')->constrained('users');
            $table->timestamps();
            $table->softDeletes();
            
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