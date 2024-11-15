<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\User;
use App\Traits\ApiResponses;

class ApprovalController extends Controller
{
    use ApiResponses;

    public function approveProduct($id)
    {
        $product = Product::where('id', $id)->update(['active' => '1']);
        return $this->ok('Product Approved Successfully!');
    }

    public function disapproveProduct($id)
    {
        $product = Product::where('id', $id)->update(['active' => '0']);
        return $this->ok('Product Disapproved Successfully!');
    }

    public function approveCategory($id)
    {
        $product = Category::where('id', $id)->update(['active' => '1']);
        return $this->ok('Category Approved Successfully!');
    }

}