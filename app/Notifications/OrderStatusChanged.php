<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

use App\Models\Order;

class OrderStatusChanged extends Notification
{
    use Queueable;

    protected $order;
    protected $status;

    /**
     * Create a new notification instance.
     */
    public function __construct(Order $order, string $status)
    {
        $this->order = $order;
        $this->status = $status;
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray(object $notifiable): array
    {
        $statusMessages = [
            'confirmed' => 'Your order has been confirmed',
            'preparing' => 'Your order is being prepared',
            'ready_for_pickup' => 'Your order is ready for pickup',
            'on_way' => 'Your order is on the way',
            'delivered' => 'Your order has been delivered',
            'cancelled' => 'Your order has been cancelled',
        ];

        return [
            'title' => 'Order Status Updated',
            'message' => $statusMessages[$this->status] ?? "Your order status is now {$this->status}",
            'order_id' => $this->order->id,
            'status' => $this->status,
            'action_url' => route('customer.orders.show', $this->order->id),
        ];
    }
}
