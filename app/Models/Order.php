<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'table_id',
        'user_id',
        'order_date',
        'total_amount',
        'status',
        'phone',         
        'address',       
        'payment_method',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function table()
    {
        return $this->belongsTo(RestaurantTable::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
    // Add this inside the class
    public function invoice()
    {
        return $this->hasOne(Invoice::class);
    }
}