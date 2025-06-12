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
        Schema::create('purchase_receipts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('purchase_contract_id')->nullable()->constrained('purchase_contracts')->onDelete('set null');
            $table->foreignId('truck_id')->nullable()->constrained('trucks')->onDelete('set null');
            $table->string('receipt_number')->unique();
            $table->date('receipt_date');
            $table->decimal('gross_weight_kg', 10, 2);
            $table->decimal('tare_weight_kg', 10, 2);
            $table->decimal('net_weight_kg', 10, 2);
            $table->decimal('final_gross_weight_kg', 10, 2);
            $table->decimal('final_tare_weight_kg', 10, 2);
            $table->decimal('final_net_weight_kg', 10, 2);
            $table->decimal('kk_percentage', 5, 2)->nullable();
            $table->decimal('ka_percentage', 5, 2)->nullable();
            $table->decimal('ffa_percentage', 5, 2)->nullable();
            $table->decimal('price_per_kg', 10, 2)->nullable();
            $table->decimal('claim_amount', 12, 2)->default(0);
            $table->decimal('total_amount', 12, 2);
            $table->text('claim_notes')->nullable();
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
        Schema::dropIfExists('purchase_receipts');
    }
};
