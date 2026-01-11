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
        // Map existing status to lowercase
        DB::table('reservations')->where('status', 'Pending')->update(['status' => 'pending']);
        DB::table('reservations')->where('status', 'Confirmed')->update(['status' => 'confirmed']);
        DB::table('reservations')->where('status', 'Completed')->update(['status' => 'completed']);
        DB::table('reservations')->where('status', 'Cancelled')->update(['status' => 'cancelled']);

        Schema::table('reservations', function (Blueprint $table) {
            $table->enum('status', ['pending', 'waiting_payment', 'confirmed', 'cancelled', 'completed'])->default('pending')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert status back to capitalized
        DB::table('reservations')->where('status', 'pending')->update(['status' => 'Pending']);
        DB::table('reservations')->where('status', 'waiting_payment')->update(['status' => 'Pending']); // or handle as needed
        DB::table('reservations')->where('status', 'confirmed')->update(['status' => 'Confirmed']);
        DB::table('reservations')->where('status', 'completed')->update(['status' => 'Completed']);
        DB::table('reservations')->where('status', 'cancelled')->update(['status' => 'Cancelled']);

        Schema::table('reservations', function (Blueprint $table) {
            $table->enum('status', ['Pending', 'Confirmed', 'Completed', 'Cancelled'])->default('Pending')->change();
        });
    }
};
