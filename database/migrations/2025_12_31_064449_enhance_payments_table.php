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
            $table->string('status')->default('Pending')->after('verified'); // Pending, Lunas, Gagal
            $table->string('method')->default('Transfer')->after('status'); // Transfer, Gateway
            $table->decimal('amount', 10, 2)->after('method');
            $table->string('transaction_id')->nullable()->after('amount');
            $table->json('gateway_response')->nullable()->after('transaction_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropColumn(['status', 'method', 'amount', 'transaction_id', 'gateway_response']);
        });
    }
};
