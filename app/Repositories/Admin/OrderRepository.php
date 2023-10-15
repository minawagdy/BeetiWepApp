<?php

namespace App\Repositories\Admin;

use App\Interfaces\Admin\OrderRepositoryInterface;
use App\Models\Order;

class OrderRepository implements OrderRepositoryInterface
{

    public function getAllOrders()
    {

        $rows = Order::with("provider","provider.images","status","driver","driver.zoneObj")->get();

        return view('admin.order.index', compact('ads'));

    }
}
