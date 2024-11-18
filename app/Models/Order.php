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
        'shop_id',
        'first_name',
        'last_name',
        'email',
        'mobile',
        'order_type',
        'status',
        'notes',
        'payment_type',
        'payment_status',
        'total',
        'service_date',
        'service_time',
        'quantity',
        'delivery_address',
        'shipping_cost',
        'shipping_date',
        'delivery_date',
        'tracking_id',
        'coupon_applied',
        'coupon_code',
        'send_invoice_to_customer',
        'approved'
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
}
