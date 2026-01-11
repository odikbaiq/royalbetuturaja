<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reservation extends Model {
    use SoftDeletes;
    protected $fillable = [
        'user_id', 'name', 'email', 'code', 'date', 'time', 'guests',
        'service_type', 'notes', 'status', 'total_price', 'bukti_pembayaran', 'snap_token', 'ticket_code'
    ];

    protected $casts = [
        'date' => 'date',
        'total_price' => 'decimal:2',
    ];

    // Relasi: Reservasi dimiliki oleh satu user
    public function user() {
        return $this->belongsTo(User::class);
    }

    // Relasi: Satu reservasi punya satu pembayaran
    public function payment() {
        return $this->hasOne(Payment::class);
    }

    // Relasi: Satu reservasi punya satu testimonial
    public function testimonial() {
        return $this->hasOne(Testimonial::class);
    }
}
