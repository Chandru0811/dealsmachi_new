<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number',
        'customer_id',
        'item_count',
        'quantity',
        'total',
        'discount',
        'shipping',
        'packaging',
        'handling',
        'taxes',
        'grand_total',
        'shipping_weight',
        'status',
        'payment_type',
        'payment_status',
        'delivery_address',
        'bdorderid',
        'mercid',
        'order_date',
        'request_token',
        'response_token',
        'payment_method_type',
        'transactionid',
        'charge_amount',
        'transaction_token',
        'transaction_status'
    ];

    public function items()
    {
        return $this->hasMany(OrderItems::class);
    }

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function shop()
    {
        return $this->belongsTo(Shop::class, 'shop_id');
    }

    public function address()
    {
        return $this->belongsTo(Address::class, 'address_id');
    }
}
