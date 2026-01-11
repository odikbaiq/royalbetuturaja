<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Map existing statuses to new ones
        DB::statement("UPDATE reservations SET status = CASE
            WHEN status IN ('confirmed', 'approved', 'waiting_payment') THEN 'waiting_payment'
            WHEN status IN ('completed', 'lunas', 'success') THEN 'success'
            WHEN status IN ('rejected', 'cancelled') THEN 'cancelled'
            ELSE 'pending'
        END");

        Schema::table('reservations', function (Blueprint $table) {
            $table->enum('status', ['pending', 'waiting_payment', 'success', 'cancelled'])->default('pending')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reservations', function (Blueprint $table) {
            $table->enum('status', ['pending', 'waiting_payment', 'confirmed', 'approved', 'cancelled', 'rejected', 'completed', 'lunas', 'success', 'failed'])->default('pending')->change();
        });
    }
};
