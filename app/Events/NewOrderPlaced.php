<?php

namespace App\Events;

use App\Models\Order;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewOrderPlaced implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $order;
    public $message;

    public function __construct(Order $order)
    {
        $this->order = $order;
        $this->message = "New order #{$order->id} has been placed!";
    }

    public function broadcastOn()
    {
        return new Channel('admin-orders'); // Public channel for admin
        // For private channel: return new PrivateChannel('admin-orders');
    }

    public function broadcastWith()
    {
        return [
            'order_id' => $this->order->id,
            'customer_name' => $this->order->customer_name,
            'total_amount' => $this->order->total_amount,
            'message' => $this->message,
            'time' => now()->toDateTimeString()
        ];
    }
}