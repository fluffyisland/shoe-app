<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Shoe;
use App\Models\ShoeColor;
use App\Models\ShoeSize;
use App\Models\ShoeVariant;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ShoeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $shoes = Shoe::with(['shoeColors.shoeSizes'])->paginate(12);

        return Inertia::render('Admin/Shoe/Index', [
            'shoes' => $shoes,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $shoeSizes = config('shoe_sizes');

        return Inertia::render('Admin/Shoe/Create', [
            'shoeSizes' => $shoeSizes,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate(
            [
                'name' => ['required', 'string', 'max:255'],
                'description' => ['required', 'string', 'max:255'],
                'price' => ['required', 'numeric'],
                'type' => ['required', 'string', 'max:255'],
                'variants' => ['required', 'array'],
                'variants.*.color.name' => ['required', 'string', 'max:255'],
                'variants.*.color.photo_url' => ['required', 'string', 'max:255'],
                'variants.*.sizes' => ['required', 'array'],
                'variants.*.sizes.*.size' => ['required', 'string', 'max:255'],
                'variants.*.sizes.*.stock' => ['required', 'numeric'],
            ],
            [
                'variants.*.color.name.required' => 'Color name is for variant.',
                'variants.*.color.photo_url.required' => 'Color photo URL is for variant.',
                'variants.*.sizes.required' => 'Sizes is required for variant.',
                'variants.*.sizes.*.size.required' => 'Size is required for variant.',
                'variants.*.sizes.*.stock.required' => 'Stock is required for size of variant.',
                'variants.*.sizes.*.stock.numeric' => 'Stock field must be a number',
            ]
        );

        $shoe = Shoe::create([
            'name' => $request->name,
            'description' => $request->description,
            'type' => $request->type,
            'price' => $request->price,
        ]);

        foreach ($request->variants as $variant) {
            $color = $variant['color'];
            $colorName = $color['name'];
            $photo_url = $color['photo_url'];
            $sizes = $variant['sizes'];

            $shoeColor = ShoeColor::create([
                'shoe_id' => $shoe->id,
                'color' => $colorName,
                'photo_url' => $photo_url,
            ]);

            foreach ($sizes as $size) {
                $sizeName = $size['size'];
                $sizestock = $size['stock'];

                ShoeSize::create([
                    'shoe_id' => $shoe->id,
                    'shoe_color_id' => $shoeColor->id,
                    'size' => $sizeName,
                    'stock' => $sizestock,
                ]);
            }
        }

        return redirect()->back()->with('flash', [
            'sweetTitle' => 'Add!',
            'sweetMessage' => 'Your Shoe has been added.',
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
        $shoe = Shoe::with('shoeColors.shoeSizes')->find($id);
        $shoeSizes = config('shoe_sizes');

        return Inertia::render('Admin/Shoe/Edit', [
            'shoe' => $shoe,
            'shoeSizes' => $shoeSizes,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate(
            [
                'name' => ['required', 'string', 'max:255'],
                'description' => ['required', 'string', 'max:255'],
                'price' => ['required', 'numeric'],
                'type' => ['required', 'string', 'max:255'],
                'variants' => ['required', 'array'],
                'variants.*.color.name' => ['required', 'string', 'max:255'],
                'variants.*.color.photo_url' => ['required', 'string', 'max:255'],
                'variants.*.sizes' => ['required', 'array'],
                'variants.*.sizes.*.size' => ['required', 'string', 'max:255'],
                'variants.*.sizes.*.stock' => ['required', 'numeric'],
            ],
            [
                'variants.*.color.name.required' => 'Color name is for variant.',
                'variants.*.color.photo_url.required' => 'Color photo URL is for variant.',
                'variants.*.sizes.required' => 'Sizes is required for variant.',
                'variants.*.sizes.*.size.required' => 'Size is required for variant.',
                'variants.*.sizes.*.stock.required' => 'Stock is required for size of variant.',
                'variants.*.sizes.*.stock.numeric' => 'Stock field must be a number',
            ]
        );

        $shoe = Shoe::find($id);
        $shoe->name = $request->name;
        $shoe->description = $request->description;
        $shoe->type = $request->type;
        $shoe->price = $request->price;
        $shoe->save();

        foreach ($request->variants as $variant) {
            $color = $variant['color'];
            $colorId = $color['id'];
            $colorName = $color['name'];
            $photo_url = $color['photo_url'];
            $sizes = $variant['sizes'];

            if ($shoeColor = ShoeColor::find($colorId)) {
                $shoeColor->shoe_id = $shoe->id;
                $shoeColor->color = $colorName;
                $shoeColor->photo_url = $photo_url;
                $shoeColor->save();
            } else {
                $shoeColor = ShoeColor::create([
                    'shoe_id' => $shoe->id,
                    'color' => $colorName,
                    'photo_url' => $photo_url,
                ]);
            }


            foreach ($sizes as $size) {
                $sizeId = $size['id'];
                $sizeName = $size['size'];
                $sizestock = $size['stock'];

                if ($shoeSize = ShoeSize::find($sizeId)) {
                    $shoeSize->shoe_id = $shoe->id;
                    $shoeSize->shoe_color_id = $shoeColor->id;
                    $shoeSize->size = $sizeName;
                    $shoeSize->stock = $sizestock;
                    $shoeSize->save();
                } else {
                    ShoeSize::create([
                        'shoe_id' => $shoe->id,
                        'shoe_color_id' => $shoeColor->id,
                        'size' => $sizeName,
                        'stock' => $sizestock,
                    ]);
                }
            }
        }

        return redirect()->back()->with('flash', [
            'sweetTitle' => 'Edit!',
            'sweetMessage' => 'Your Shoe has been Edited.',
            'sweetStyle' => 'success',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $ShoeColor = ShoeColor::find($id);
        $shoeId = $ShoeColor->shoe->id;
        $ShoeColor->delete();

        if (ShoeColor::where('shoe_id', $shoeId)->get()->count() == 0) {
            $shoe = Shoe::find($shoeId);
            $shoe->delete();
        }

        return redirect()->back()->with('flash', [
            'sweetTitle' => 'Delete!',
            'sweetMessage' => 'Your Shoe has been Deleted.',
            'sweetStyle' => 'success',
        ]);
    }
}
