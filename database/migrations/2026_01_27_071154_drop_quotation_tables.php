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
        Schema::dropIfExists('quotation_items');
        Schema::dropIfExists('quotations');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::create('quotations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('bill_to');
            $table->string('ship_to')->nullable();
            $table->date('date');
            $table->date('due_date')->nullable();
            $table->string('payment_terms')->nullable();
            $table->string('po_number')->nullable();
            $table->decimal('subtotal', 10, 2);
            $table->decimal('tax', 10, 2)->default(0);
            $table->decimal('discount', 10, 2)->default(0);
            $table->decimal('shipping', 10, 2)->default(0);
            $table->decimal('total', 10, 2);
            $table->decimal('paid', 10, 2)->default(0);
            $table->decimal('balance', 10, 2);
            $table->text('notes')->nullable();
            $table->text('terms')->nullable();
            $table->enum('type', ['quotation', 'invoice'])->default('quotation');
            $table->timestamps();
        });

        Schema::create('quotation_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quotation_id')->constrained()->onDelete('cascade');
            $table->string('item_name');
            $table->integer('quantity');
            $table->decimal('rate', 10, 2);
            $table->decimal('amount', 10, 2);
            $table->timestamps();
        });
    }
};