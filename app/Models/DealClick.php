<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DealClick extends Model
{
    use HasFactory;

    protected $fillable = ['deal_id','user_id','ip_address','clicked_at'];
}
