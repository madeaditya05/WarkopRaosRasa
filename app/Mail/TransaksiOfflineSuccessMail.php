<?php

namespace App\Mail;

use App\Models\TransaksiOffline;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TransaksiOfflineSuccessMail extends Mailable
{
    use Queueable, SerializesModels;

    public $transaksi;

    public function __construct(TransaksiOffline $transaksi)
    {
        $this->transaksi = $transaksi;
    }

    public function build()
    {
        return $this->subject('Konfirmasi Transaksi Offline')
                    ->view('emails.transaksi_offline_success');
    }
}
