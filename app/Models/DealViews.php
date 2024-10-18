<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DealViews extends Model
{
    use HasFactory;

    protected $fillable = ['deal_id','user_id','ip_address','viewed_at'];
}
