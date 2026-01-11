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
        // Map existing status to new values
        DB::table('reservations')->where('status', 'pending')->update(['status' => 'Pending']);
        DB::table('reservations')->where('status', 'lunas')->update(['status' => 'Confirmed']);
        DB::table('reservations')->where('status', 'batal')->update(['status' => 'Cancelled']);

        Schema::table('reservations', function (Blueprint $table) {
            $table->enum('status', ['Pending', 'Confirmed', 'Completed', 'Cancelled'])->default('Pending')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert status back
        DB::table('reservations')->where('status', 'Pending')->update(['status' => 'pending']);
        DB::table('reservations')->where('status', 'Confirmed')->update(['status' => 'lunas']);
        DB::table('reservations')->where('status', 'Completed')->update(['status' => 'completed']);
        DB::table('reservations')->where('status', 'Cancelled')->update(['status' => 'batal']);

        Schema::table('reservations', function (Blueprint $table) {
            $table->enum('status', ['pending', 'lunas', 'batal'])->default('pending')->change();
        });
    }
};
