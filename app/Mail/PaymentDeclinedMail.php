<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PaymentDeclinedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $order;
    public $reason;

    /**
     * Create a new message instance.
     *
     * @param Order $order
     * @param string|null $reason
     */
    public function __construct(Order $order, $reason = null)
    {
        $this->order = $order;
        $this->reason = $reason;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Payment Declined - Order #' . $this->order->order_number)
                    ->view('emails.payment_declined')
                    ->with([
                        'order' => $this->order,
                        'reason' => $this->reason
                    ]);
    }
}
