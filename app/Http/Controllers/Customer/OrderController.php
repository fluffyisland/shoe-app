<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderShoe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $user = auth()->user();
        $orders = $user->orders()->with('order_shoes', 'order_shoes.shoe', 'order_shoes.shoe_color', 'order_shoes.shoe_size')->paginate(12);
        $orderStatus = config('order_status');

        return Inertia::render('Customer/Order', [
            'orders' => $orders,
            'orderStatus' => $orderStatus,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'slip_image' => 'required',
            'total_price' => 'required|numeric',
        ]);

        $user = auth()->user();

        $order = Order::create([
            'user_id' => $user->id,
            'total_amount' => $request->total_price,
            'slip_image' => $request->slip_image,
        ]);

        foreach ($request->carts as $cart) {
            OrderShoe::create([
                'order_id' => $order->id,
                'shoe_id' => $cart['shoe']['id'],
                'shoe_color_id' => $cart['color']['id'],
                'shoe_size_id' => $cart['size']['id'],
                'quantity' => $cart['quantity'],
                'price' => $cart['price'],
            ]);
        }


        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
