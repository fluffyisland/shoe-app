<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderShoe;
use Illuminate\Http\Request;
use Inertia\Inertia;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = Order::with('order_shoes', 'order_shoes.shoe', 'order_shoes.shoe_color', 'order_shoes.shoe_size')->paginate(12);
        $orderStatus = config('order_status');

        return Inertia::render('Admin/Order/Index', [
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
        //
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
        $order = Order::find($id);
        $order->status = $request->status;
        $order->save();

        return redirect()->back()->with('flash', [
            'sweetTitle' => 'Updated!',
            'sweetMessage' => 'Your Order has been Updated.',
            'sweetStyle' => 'success',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
