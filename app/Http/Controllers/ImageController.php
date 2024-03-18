<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ImageController extends Controller
{
    /**
     * Adds an image to the server
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    function addImage(Request $request) {
        return response()->json([
            'success' => true,
            'data' => saveImage($request),
            'message' => "Image successfully saved",
        ]);
    }

    /**
     * Removes an image with the given path from the server
     *
     * @param $image
     * @return \Illuminate\Http\JsonResponse
     */
    function removeImage($image) {
        return response()->json([
            'success' => true,
            'data' => deleteImage($image),
            'message' => "Image successfully deleted",
        ]);
    }
}
