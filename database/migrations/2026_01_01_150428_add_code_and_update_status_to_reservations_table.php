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
        Schema::table('reservations', function (Blueprint $table) {
            $table->string('code')->nullable()->unique()->after('id');
        });

        // Generate unique codes for existing reservations
        $reservations = DB::table('reservations')->get();
        foreach ($reservations as $reservation) {
            $code = 'RES-' . str_pad($reservation->id, 6, '0', STR_PAD_LEFT);
            DB::table('reservations')->where('id', $reservation->id)->update(['code' => $code]);
        }

        // Map existing status to new enum values
        DB::table('reservations')->where('status', 'Pending')->update(['status' => 'pending']);
        DB::table('reservations')->where('status', 'Dikonfirmasi')->update(['status' => 'lunas']);
        DB::table('reservations')->where('status', 'Dibatalkan')->update(['status' => 'batal']);
        // Any other status will be set to 'pending' as default

        Schema::table('reservations', function (Blueprint $table) {
            $table->enum('status', ['pending', 'lunas', 'batal'])->default('pending')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reservations', function (Blueprint $table) {
            $table->dropColumn('code');
            $table->string('status')->default('Pending')->change();
        });
    }
};
