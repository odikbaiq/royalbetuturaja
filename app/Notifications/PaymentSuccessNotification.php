<?php

namespace App\Notifications;

use App\Models\Reservation;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PaymentSuccessNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $reservation;

    /**
     * Create a new notification instance.
     */
    public function __construct(Reservation $reservation)
    {
        $this->reservation = $reservation;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Pembayaran Berhasil - Royal Betutu Raja')
            ->greeting('Halo Admin!')
            ->line('Ada pembayaran baru yang berhasil diproses.')
            ->line('**Detail Pembayaran:**')
            ->line('Kode Reservasi: ' . $this->reservation->code)
            ->line('Customer: ' . $this->reservation->user->name)
            ->line('Layanan: ' . ucfirst($this->reservation->service_type))
            ->line('Tanggal: ' . $this->reservation->date->format('d/m/Y'))
            ->line('Total Pembayaran: Rp ' . number_format($this->reservation->total_price, 0, ',', '.'))
            ->action('Lihat Detail', route('admin.reservation.show', $this->reservation->id))
            ->line('Silakan cek dashboard admin untuk detail lebih lanjut.')
            ->salutation('Salam, Sistem Royal Betutu Raja');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'reservation_id' => $this->reservation->id,
            'reservation_code' => $this->reservation->code,
            'customer_name' => $this->reservation->user->name,
            'amount' => $this->reservation->total_price,
        ];
    }
}
