<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class NewOrderNotification extends Notification
{
    use Queueable;

    public Order $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(object $notifiable): array
    {
        $customer = $this->order->customer;

        return [
            'type'           => 'order_placed',
            'title'          => 'New Order Received',
            'order_id'       => $this->order->id,
            'customer_id'    => $this->order->customer_id,
            'customer_name'  => $customer ? $customer->name : 'Customer',
            'customer_email' => $customer ? $customer->email : '',
            'total_amount'   => (float) $this->order->total_amount,
            'pickup_date'    => $this->order->pickup_date,
            'pickup_time'    => $this->order->pickup_time,
            'placed_at'      => $this->order->created_at ? $this->order->created_at->toIso8601String() : now()->toIso8601String(),
            'message'        => "New Order #{$this->order->id} placed by " . ($customer ? $customer->name : 'Customer') . " ($" . number_format($this->order->total_amount, 2) . ")",
        ];
    }

    public function toArray(object $notifiable): array
    {
        return $this->toDatabase($notifiable);
    }
}
