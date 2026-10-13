<?php

namespace App\Events;

use App\Models\Order;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class OrderStatusUpdated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $order;
    public $oldStatus;
    public $message;

    public function __construct(Order $order, $oldStatus)
    {
        $this->order = $order;
        $this->oldStatus = $oldStatus;
        $this->message = "Order #{$order->id} status changed from {$oldStatus} to {$order->status}";
    }

    public function broadcastOn()
    {
        return new Channel('admin-orders');
    }

    public function broadcastWith()
    {
        return [
            'order_id' => $this->order->id,
            'customer_name' => $this->order->customer->name ?? 'Guest',
            'total_amount' => $this->order->total_amount,
            'old_status' => $this->oldStatus,
            'new_status' => $this->order->status,
            'message' => $this->message,
            'time' => now()->toDateTimeString()
        ];
    }
}