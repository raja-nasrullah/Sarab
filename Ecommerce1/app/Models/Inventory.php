<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;

    // 👇 ADD THIS ONE LINE RIGHT HERE!
    protected $table = 'inventory'; 
    // 👆 ADD THIS ONE LINE RIGHT HERE!

    protected $fillable = [
        'name',
        'quantity',
        'unit',
    ];

    public function purchaseItems()
    {
        return $this->hasMany(PurchaseItem::class, 'inventory_id');
    }
}