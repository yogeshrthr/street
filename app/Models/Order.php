<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable = [
        'order_id',
        'customer_id',
        'name',
        'email',
        'phone',
        'address',
        'state',
        'city',
        'pin_code',
        'price',
        'quantity',
        'product_id',
        'product_title',
        'product_image',
        'payment_mode',
        'transaction_id',
        'payment_status',
        'stock_id'
    ];
    public function stock()
    {
        return $this->hasOne(Stock::class, 'id', 'stock_id');
    }
}
