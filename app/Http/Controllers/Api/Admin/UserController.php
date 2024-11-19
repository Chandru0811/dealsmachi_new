<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use App\Traits\ApiResponses;

class UserController extends Controller
{
    use ApiResponses;

    public function getAllUser()
    {
        $users = User::where('role', 3)->get();
        return $this->success('User retrieved successfully.', $users);
    }

    public function userShow($id)
    {
        $user = User::where('role', 3)->find($id);

        if (!$user) {
            return $this->error('User Not Found.', ['error' => 'User Not Found'], 404);
        }

        return $this->success('User Retrived Succesfully!', $user);
    }

    public function getAllOrders()
    {
        $orders = Order::with([
            'items.product' => function ($query) {
                $query->select('id', 'name');
            },
            'shop' => function ($query) {
                $query->select('id', 'legal_name');
            },
            'customer' => function ($query) {
                $query->select('id', 'name');
            }
        ])->orderBy('created_at', 'desc')->get();

        return $this->success('Orders Retrived Successfully', $orders);
    }

    public function getOrderById($id)
    {
        $order = Order::with(['items.product','shop','customer',])->find($id);

        if (!$order) {
            return $this->error('Order Summary Not Found.', ['error' => 'Order Summary Not Found']);
        }

        return $this->success('Order Summary Retrived Successfully', $order);

    }
}