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
        Schema::create('sales_tax_invoices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sales_invoice_id')->constrained('sales_invoices')->onDelete('cascade');
            $table->string('tax_invoice_number')->unique();
            $table->date('tax_invoice_date');
            $table->decimal('dpp_amount', 12, 2);
            $table->decimal('ppn_amount', 12, 2);
            $table->text('notes')->nullable();
            $table->enum('payment_status', ['pending', 'paid', 'partially_paid', 'overdue'])->default('pending');
            $table->date('payment_date')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales_tax_invoices');
    }
};
