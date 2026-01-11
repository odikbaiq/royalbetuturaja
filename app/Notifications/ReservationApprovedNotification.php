<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class ReservationApprovedNotification extends Notification
{
    use Queueable;

    protected $reservation;

    public function __construct($reservation)
    {
        $this->reservation = $reservation;
    }

    public function via($notifiable)
    {
        return ['database']; // Mengirim via Database saja untuk mempercepat
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Reservasi Anda Siap Dibayar - Royal Betutu Raja')
            ->greeting('Halo, ' . $this->reservation->user->name)
            ->line('Kabar baik! Reservasi Anda dengan kode #' . $this->reservation->code . ' telah kami setujui.')
            ->line('Sekarang Anda dapat melanjutkan ke proses pembayaran untuk mendapatkan konfirmasi akhir.')
            ->action('Bayar Sekarang', url('/customer/payment/pay/' . $this->reservation->id))
            ->line('Setelah pembayaran berhasil, Anda akan menerima E-Tiket dan konfirmasi akhir.')
            ->line('Terima kasih telah memilih Royal Betutu Raja!');
    }

    public function toArray($notifiable)
    {
        return [
            'reservation_id' => $this->reservation->id,
            'message' => 'Reservasi #' . $this->reservation->code . ' telah disetujui.'
        ];
    }
}
