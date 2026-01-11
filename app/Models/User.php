<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable {
    use HasFactory, Notifiable;

    protected $fillable = ['name', 'email', 'password', 'role', 'profile_picture'];

    // Relasi: Satu user bisa punya banyak reservasi
    public function reservations() {
        return $this->hasMany(Reservation::class);
    }

    // Relasi: Satu user bisa punya banyak testimonial
    public function testimonials() {
        return $this->hasMany(Testimonial::class);
    }
}
