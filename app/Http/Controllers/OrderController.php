<?php

namespace App\Http\Controllers;

use App\Enums\Order\OrderByEnum;
use App\Http\Filters\OrderFilter;
use App\Http\Requests\Order\IndexRequest;
use App\Models\Order;

class OrderController extends Controller
{
    public function index(IndexRequest $request)
    {
        $data = $request->validated();

        $filter = app()->make(OrderFilter::class, ['queryParams' => array_filter($data)]);
        $orders = Order::filter($filter);

        return view('order.index', [
            'orders' => $orders->with('user')->paginate(15),
        ]);
    }

    public function edit(Order $order)
    {
        return view('order.edit', ['order' => $order]);
    }

    public function update()
    {

    }

    public function destroy(Order $order)
    {
        $order->delete();
        return redirect()->route('orders.index')
            ->with('status', 'Заказ № "' . $order->id . '" удален.');
    }
}
