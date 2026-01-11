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
        // Update existing records: map 'menunggu' to 'Pending', 'diterima' to 'Dikonfirmasi', 'ditolak' to 'Dibatalkan'
        DB::table('reservations')->where('status', 'menunggu')->update(['status' => 'Pending']);
        DB::table('reservations')->where('status', 'diterima')->update(['status' => 'Dikonfirmasi']);
        DB::table('reservations')->where('status', 'ditolak')->update(['status' => 'Dibatalkan']);

        // Change default status to 'Pending'
        Schema::table('reservations', function (Blueprint $table) {
            $table->string('status')->default('Pending')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert status back
        DB::table('reservations')->where('status', 'Pending')->update(['status' => 'menunggu']);
        DB::table('reservations')->where('status', 'Dikonfirmasi')->update(['status' => 'diterima']);
        DB::table('reservations')->where('status', 'Dibatalkan')->update(['status' => 'ditolak']);

        Schema::table('reservations', function (Blueprint $table) {
            $table->string('status')->default('menunggu')->change();
        });
    }
};
