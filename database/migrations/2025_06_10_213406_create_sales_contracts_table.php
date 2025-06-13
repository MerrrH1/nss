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
        Schema::create('sales_contracts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('buyer_id')->constrained('buyers')->onDelete('cascade');
            $table->string('contract_number')->unique();
            $table->date('contract_date');
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->foreign('commodity_id')->constrained('commodities')->onDelete('cascade');
            $table->decimal('total_quantity_kg', 10, 2);
            $table->decimal('price_per_kg', 10, 2);
            $table->decimal('tolerated_kk_percentage', 5, 2)->default(0);
            $table->decimal('tolerated_ka_percentage', 5, 2)->default(0);
            $table->decimal('tolerated_ffa_percentage', 5, 2)->default(0);
            $table->decimal('quantity_delivered_kg', 10, 2)->default(0);
            $table->enum('status', ['active', 'completed', 'canceled'])->default('active');
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales_contracts');
    }
};
