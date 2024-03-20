<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UploadController extends Controller
{
    public function upload(Request $request)
    {
        $request->validate([
            'photo_url' => 'required',
        ]);

        if ($request->hasFile('photo_url')) {
            $file = $request->file('photo_url');
            $filename = uniqid() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('uploads', $filename, 'public');
            return response()->json(['path' => $path], 200);
        }

        return response()->json(['error' => 'Failed to upload file.'], 400);
    }
}
