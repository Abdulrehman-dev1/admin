<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SellerOrderNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $order;
    public $sellerItems;

    /**
     * Create a new message instance.
     *
     * @param Order $order
     * @param array $sellerItems
     */
    public function __construct(Order $order, $sellerItems)
    {
        $this->order = $order;
        $this->sellerItems = $sellerItems;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('New Order for Your Items - Order #' . $this->order->order_number)
                    ->view('emails.seller_order_notification')
                    ->with([
                        'order' => $this->order,
                        'items' => $this->sellerItems
                    ]);
    }
}
