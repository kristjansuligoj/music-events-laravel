<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ImageController extends Controller
{
    function addImage(Request $request) {
        return response()->json([
            'success' => true,
            'data' => saveImage($request),
            'message' => "Image successfully saved",
        ]);
    }

    function removeImage($image) {
        return response()->json([
            'success' => true,
            'data' => deleteImage($image),
            'message' => "Image successfully deleted",
        ]);
    }
}
