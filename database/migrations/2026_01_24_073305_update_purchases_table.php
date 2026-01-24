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
        Schema::table('purchases', function (Blueprint $table) {
            // Drop foreign key constraints before dropping columns
            $table->dropForeign(['product_id']);
            $table->dropColumn('product_id');
            $table->dropColumn('quantity');
            $table->dropColumn('cost');

            // Add new columns
            $table->foreignId('vendor_id')->constrained('vendors')->onDelete('cascade')->after('id');
            $table->string('invoice_no')->unique()->after('vendor_id');
            $table->decimal('total_amount', 10, 2)->default(0.00)->after('invoice_no');
            // 'status' and 'created_by' are already present and correctly defined from initial migration.
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('purchases', function (Blueprint $table) {
            // Revert new columns
            $table->dropForeign(['vendor_id']);
            $table->dropColumn('vendor_id');
            $table->dropColumn('invoice_no');
            $table->dropColumn('total_amount');

            // Re-add columns removed by this migration
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade')->after('id');
            $table->integer('quantity')->after('product_id');
            $table->decimal('cost', 12, 2)->after('quantity');
        });
    }
};
