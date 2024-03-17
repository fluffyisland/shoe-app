<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\OrderShoe;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
            'shoe_id' => 'required|exists:shoes,id',
            'shoe_color_id' => 'required|exists:shoe_colors,id',
            'shoe_size_id' => 'required|exists:shoe_sizes,id',
            'quantity' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
            'slip_image' => 'required',
        ]);

        OrderShoe::create([
            'user_id' => auth()->user()->id,
            'shoe_id' => $request->shoe_id,
            'shoe_color_id' => $request->shoe_color_id,
            'shoe_size_id' => $request->shoe_size_id,
            'quantity' => $request->quantity,
            'price' => $request->price,
            'slip_image' => $request->slip_image,
        ]);

        return redirect()->back()->with('flash', [
            'sweetTitle' => 'Confirm!',
            'sweetMessage' => 'Your order has been store.',
            'sweetStyle' => 'success',
        ]);
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
