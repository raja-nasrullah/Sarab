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
    Schema::create('invoices', function (Blueprint $table) {
        $table->id();
        $table->foreignId('order_id')->constrained('orders')->onDelete('cascade');
        $table->string('invoice_number')->unique();
        $table->date('issued_date');
        $table->date('due_date');
        $table->decimal('subtotal', 10, 2);
        $table->decimal('discount_percent', 5, 2)->default(0);
        $table->decimal('tax_percent', 5, 2)->default(0);
        $table->decimal('total_amount', 10, 2);
        $table->string('status')->default('pending'); // pending, paid, cancelled
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
