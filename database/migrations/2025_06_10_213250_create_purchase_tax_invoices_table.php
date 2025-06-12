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
        Schema::create('purchase_tax_invoices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('purchase_invoice_id')->nullable()->constrained('purchase_invoices')->onDelete('set null');
            $table->string('tax_invoice_number')->unique();
            $table->date('tax_invoice_date');
            $table->decimal('dpp_amount', 12, 2);
            $table->decimal('ppn_amount', 12, 2);
            $table->enum('payment_status', ['pending', 'paid', 'partially_paid', 'overdue'])->default('pending');
            $table->date('payment_date')->nullable();
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
        Schema::dropIfExists('purchase_tax_invoices');
    }
};
