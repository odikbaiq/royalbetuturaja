<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model {
    protected $fillable = ['reservation_id', 'proof_image', 'verified', 'status', 'method', 'amount', 'transaction_id', 'gateway_response', 'payment_type', 'va_number', 'snap_token'];

    protected $casts = [
        'gateway_response' => 'array',
    ];

    // Relasi: Pembayaran merujuk ke satu reservasi
    public function reservation() {
        return $this->belongsTo(Reservation::class);
    }
}
