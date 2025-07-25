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
        Schema::table('sales_invoice_delivery', function (Blueprint $table) {
            // Ganti nama kolom dari singular ke plural
            $table->renameColumn('sales_delivery_id', 'sales_deliveries_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sales_invoice_delivery', function (Blueprint $table) {
            // Kembalikan nama kolom jika di-rollback
            $table->renameColumn('sales_deliveries_id', 'sales_delivery_id');
        });
    }
};