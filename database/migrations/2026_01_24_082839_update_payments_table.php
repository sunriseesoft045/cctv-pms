<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint; // Corrected
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            // Drop foreign key constraints before dropping columns
            $table->dropForeign(['sale_id']);
            $table->dropColumn('sale_id');

            // Add new columns
            $table->enum('type', ['customer', 'vendor'])->after('id');
            $table->foreignId('sale_id')->nullable()->constrained('sales')->onDelete('cascade')->after('type');
            $table->foreignId('purchase_id')->nullable()->constrained('purchases')->onDelete('cascade')->after('sale_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            // Revert new columns
            $table->dropForeign(['purchase_id']);
            $table->dropColumn('purchase_id');
            $table->dropForeign(['sale_id']); // This sale_id was nullable in up(), drop it here.
            $table->dropColumn('sale_id');
            $table->dropColumn('type');

            // Re-add original columns from create_payments_table
            $table->foreignId('sale_id')->constrained('sales')->cascadeOnDelete()->after('id'); // Original non-nullable sale_id
        });
    }
};