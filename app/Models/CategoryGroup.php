<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class CategoryGroup extends Model
{
    use SoftDeletes;

    protected $fillable = ['name', 'slug', 'description', 'icon', 'image_path', 'active', 'order'];

    protected $dates = ['deleted_at'];

    public function categories()
    {
        return $this->hasMany(Category::class);
    }
}
