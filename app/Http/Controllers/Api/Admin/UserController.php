<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItems;
use App\Models\User;
use Illuminate\Http\Request;
use App\Traits\ApiResponses;

class UserController extends Controller
{
    use ApiResponses;

    public function getAllUser()
    {
        $users = User::where('role', 3)->orderBy('created_at', 'desc')->get();
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
        $orderItems = OrderItems::with([
            'order' => function ($query) {
                $query->select('id', 'order_number', 'customer_id', 'created_at');
            },
            'order.customer' => function ($query) {
                $query->select('id', 'name');
            },
            'shop' => function ($query) {
                $query->select('id', 'legal_name');
            }
        ])->orderBy('created_at', 'desc')->get();

        return $this->success('Order Items Retrieved Successfully', $orderItems);
    }


    public function getOrderById($order_id, $product_id)
    {
        $orderItem = OrderItems::with([
            'product.productMedia',
            'shop',
            'order.customer',
            'order.address'
        ])
            ->where('order_id', $order_id)
            ->where('product_id', $product_id)
            ->first();

        if (!$orderItem) {
            return $this->error('Order Item Not Found.', ['error' => 'Order Item Not Found']);
        }
        $orderItem->update(['viewed_by_admin' => 0]);

        return $this->success('Order Item Retrieved Successfully', $orderItem);
    }
}
