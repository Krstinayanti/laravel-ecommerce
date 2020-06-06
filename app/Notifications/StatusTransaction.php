<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class StatusTransaction extends Notification
{
    use Queueable;

    protected $status;
    protected $productName;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($transaction)
    {
        $products = $transaction->details()->first()->products()->first();
        $this->productName = $products->product_name;
        $this->status = $transaction->status;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {

        switch($this->status) {
            case 'unverified';
                $data = "Status Pemesanan anda belum terverifikasi.";
            break;

            case 'verified';
                $data = "Status Pemesanan anda sudah terverifikasi.";
            break;

            case 'delivered';
                $data = "Barang yang anda pesan telah sampai ditujuan.";
            break;

            case 'success';
                $data = "Status Pemesanan anda telah berhasil.";
            break;

            case 'expired';
                $data = "Status Pemesanan anda telah kadaluarsa.";
            break;

            case 'canceled';
                $data = "Status Pemesanan anda telah dibatalkan.";
            break;
        }

        return [
            'data' => [
                'product_name' => $this->productName,
                'status' => $data,
            ],
        ];
    }
}
