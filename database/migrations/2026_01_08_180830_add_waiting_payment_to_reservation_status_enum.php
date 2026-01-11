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
        // First ensure all existing records have valid status values
        DB::table('reservations')
            ->whereNotIn('status', ['Pending', 'Confirmed', 'Completed', 'Cancelled'])
            ->update(['status' => 'Pending']);

        Schema::table('reservations', function (Blueprint $table) {
            $table->enum('status', ['Pending', 'waiting_payment', 'Confirmed', 'Completed', 'Cancelled'])->default('Pending')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reservations', function (Blueprint $table) {
            $table->enum('status', ['Pending', 'Confirmed', 'Completed', 'Cancelled'])->default('Pending')->change();
        });
    }
};
