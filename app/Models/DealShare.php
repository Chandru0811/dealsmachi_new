<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DealShare extends Model
{
    use HasFactory;

    protected $fillable = ['deal_id','user_id','ip_address','share_at'];
}
