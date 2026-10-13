<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('phone', 30)->nullable()->after('total_amount');
            $table->text('address')->nullable()->after('phone');
            $table->string('payment_method', 50)->nullable()->after('address');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['phone', 'address', 'payment_method']);
        });
    }
};