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
        Schema::table('payments', function (Blueprint $table) {
            // Drop things we don't need
            if (Schema::hasColumn('payments', 'type')) {
                $table->dropColumn('type');
            }
            if (Schema::hasColumn('payments', 'method')) {
                $table->dropColumn('method');
            }

            // Rename created_by to user_id if it exists
            if (Schema::hasColumn('payments', 'created_by')) {
                $table->renameColumn('created_by', 'user_id');
            } else if (!Schema::hasColumn('payments', 'user_id')) {
                 $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            }


            // Add new columns if they don't exist
            if (!Schema::hasColumn('payments', 'vendor_name')) {
                $table->string('vendor_name')->after('purchase_id');
            }
            if (!Schema::hasColumn('payments', 'payment_mode')) {
                $table->string('payment_mode')->after('amount');
            }
            if (!Schema::hasColumn('payments', 'payment_date')) {
                $table->date('payment_date')->after('payment_mode');
            }
            if (!Schema::hasColumn('payments', 'note')) {
                $table->text('note')->nullable()->after('payment_date');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            // Reverse the changes made in up()
            if (Schema::hasColumn('payments', 'vendor_name')) {
                $table->dropColumn('vendor_name');
            }
            if (Schema::hasColumn('payments', 'payment_mode')) {
                $table->dropColumn('payment_mode');
            }
            if (Schema::hasColumn('payments', 'payment_date')) {
                $table->dropColumn('payment_date');
            }
            if (Schema::hasColumn('payments', 'note')) {
                $table->dropColumn('note');
            }

            if (Schema::hasColumn('payments', 'user_id')) {
                $table->renameColumn('user_id', 'created_by');
            }

            if (!Schema::hasColumn('payments', 'type')) {
                $table->enum('type', ['customer', 'vendor'])->after('id');
            }
            if (!Schema::hasColumn('payments', 'method')) {
                $table->enum('method', ['cash', 'upi', 'bank'])->default('cash');
            }
        });
    }
};
