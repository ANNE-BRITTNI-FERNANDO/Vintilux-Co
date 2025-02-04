<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ImageController extends Controller
{
    public function showProductImage($filename)
    {
        $path = storage_path("app/public/products/{$filename}");

        if (file_exists($path)) {
            return response()->file($path);
        }

        return response()->json(['message' => 'Image not found'], 404);
    }

    public function showGalleryImage($filename)
    {
        $path = storage_path("app/public/product_galleries/{$filename}");

        if (file_exists($path)) {
            return response()->file($path);
        }

        return response()->json(['message' => 'Image not found'], 404);
    }
}
