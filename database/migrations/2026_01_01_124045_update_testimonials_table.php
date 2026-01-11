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
        Schema::table('testimonials', function (Blueprint $table) {
            // Drop old columns that exist
            if (Schema::hasColumn('testimonials', 'name')) {
                $table->dropColumn('name');
            }
            if (Schema::hasColumn('testimonials', 'role')) {
                $table->dropColumn('role');
            }
            if (Schema::hasColumn('testimonials', 'photo')) {
                $table->dropColumn('photo');
            }

            // Add new columns
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('reservation_id')->constrained('reservations')->onDelete('cascade');
            $table->tinyInteger('rating')->unsigned(); // 1-5 stars

            // Add unique constraint: one testimonial per reservation
            $table->unique('reservation_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('testimonials', function (Blueprint $table) {
            // Drop new columns
            $table->dropForeign(['user_id']);
            $table->dropForeign(['reservation_id']);
            $table->dropColumn(['user_id', 'reservation_id', 'rating']);
            $table->dropUnique(['reservation_id']);

            // Restore old columns
            $table->string('name');
            $table->string('role')->nullable()->default('Pelanggan');
            $table->string('photo')->nullable();
        });
    }
};
