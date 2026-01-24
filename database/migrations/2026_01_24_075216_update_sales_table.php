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
        Schema::table('sales', function (Blueprint $table) {
            // Remove existing columns no longer needed in this table, they will be in sale_items
            $table->dropForeign(['product_id']);
            $table->dropColumn('product_id');
            $table->dropColumn('quantity');
            $table->dropColumn('price');

            // Add new columns
            $table->foreignId('customer_id')->constrained('customers')->onDelete('cascade')->after('id');
            $table->string('invoice_no')->unique()->after('customer_id');
            $table->decimal('total_amount', 10, 2)->default(0.00)->after('invoice_no');
            $table->decimal('gst_amount', 10, 2)->default(0.00)->after('total_amount');
            // 'status' and 'created_by' are already present and correctly defined from initial migration.
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sales', function (Blueprint $table) {
            // Revert new columns
            $table->dropForeign(['customer_id']);
            $table->dropColumn('customer_id');
            $table->dropColumn('invoice_no');
            $table->dropColumn('total_amount');
            $table->dropColumn('gst_amount');

            // Re-add columns removed by this migration (assuming no data loss if rollback is needed)
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade')->after('id');
            $table->integer('quantity')->after('product_id');
            $table->decimal('price', 12, 2)->after('quantity');
        });
    }
};