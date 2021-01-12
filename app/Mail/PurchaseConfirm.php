<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PurchaseConfirm extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    public $order_info = "";
    public $order_details_info = "";

    public function __construct($order, $order_details)
    {
        $this->order_info = $order;
        $this->order_details_info = $order_details;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.purchase_confirmation', [
            'final_order_info' => $this->order_info,
            'final_order_details' => $this->order_details_info
        ]);
    }
}
