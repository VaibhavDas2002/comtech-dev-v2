<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\GalleryItem;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GalleryApiController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = GalleryItem::query()->orderBy('sort_order');

        if ($request->filled('category')) {
            $query->where('category', $request->query('category'));
        }

        $items = $query->get();

        return response()->json([
            'success' => true,
            'data' => $items,
        ]);
    }
}
