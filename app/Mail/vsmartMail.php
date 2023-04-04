<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class vsmartMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $data;
    public function __construct($data)
    {
        $this->data=$data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $order_code=$this->data['order_code'];
        return $this->view('client.mail.index')
                    ->from('vsmartshop01@gmail.com','Vsmart')
                    ->subject('[Vsmart] Xác nhận đơn hàng '.$order_code)
                    ->with($this->data);
    }
}
