<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dealenquire extends Model
{
    use HasFactory;

    protected $fillable = ['deal_id','user_id','ip_address','enquire_at'];
}
