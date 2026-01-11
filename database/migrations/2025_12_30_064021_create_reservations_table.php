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
    Schema::create('reservations', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->date('date');
        $table->time('time');
        $table->integer('guests');
        $table->string('service_type'); // Gala Dinner, Cooking Class, dll
        $table->string('status')->default('menunggu'); // menunggu, diterima, ditolak
        $table->text('notes')->nullable();
        $table->timestamps();
    });
}
};
