<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RestaurantTable extends Model
{
    use HasFactory;

    protected $fillable = [
        'table_number',
        'capacity',
        'status',
    ];

    public function orders()
    {
        // Added 'table_id' to tell Laravel which column to use
        return $this->hasMany(Order::class, 'table_id');
    }

    public function reservations()
    {
        // Added 'table_id' to tell Laravel which column to use
        return $this->hasMany(Reservation::class, 'table_id');
    }
}