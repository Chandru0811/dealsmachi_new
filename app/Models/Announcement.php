<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Announcement extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'message',
        'type',
        'image_url',
        'start_date',
        'end_date',
        'active',
        'is_global',
        'shop_id',
    ];

    protected $dates = ['deleted_at'];
    
    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }
}
