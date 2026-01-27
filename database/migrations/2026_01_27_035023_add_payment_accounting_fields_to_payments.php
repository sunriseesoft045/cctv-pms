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
            if (!Schema::hasColumn('payments', 'type')) {
                $table->enum('type', ['purchase','sale'])->after('user_id');
            }
            if (!Schema::hasColumn('payments', 'total_amount')) {
                $table->decimal('total_amount',10,2)->after('sale_id')->default(0);
            }
            if (!Schema::hasColumn('payments', 'paid_amount')) {
                $table->decimal('paid_amount',10,2)->after('total_amount')->default(0);
            }
            if (!Schema::hasColumn('payments', 'due_amount')) {
                $table->decimal('due_amount',10,2)->after('paid_amount')->default(0);
            }
            if (!Schema::hasColumn('payments', 'advance_amount')) {
                $table->decimal('advance_amount',10,2)->after('due_amount')->default(0);
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropColumn('type');
            $table->dropColumn('total_amount');
            $table->dropColumn('paid_amount');
            $table->dropColumn('due_amount');
            $table->dropColumn('advance_amount');
        });
    }
};
