<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BlogApiController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = Blog::with('category')->where('is_published', true)->orderByDesc('published_at');

        if ($request->filled('category')) {
            $query->whereHas('category', function ($q) use ($request): void {
                $q->where('slug', $request->query('category'));
            });
        }

        if ($request->filled('search')) {
            $search = $request->query('search');
            $query->where(function ($q) use ($search): void {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('excerpt', 'like', "%{$search}%")
                    ->orWhere('content', 'like', "%{$search}%");
            });
        }

        $perPage = $request->integer('per_page', 10);
        $blogs = $query->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => $blogs->items(),
            'meta' => [
                'current_page' => $blogs->currentPage(),
                'last_page' => $blogs->lastPage(),
                'per_page' => $blogs->perPage(),
                'total' => $blogs->total(),
            ],
        ]);
    }

    public function show(string $slug): JsonResponse
    {
        $blog = Blog::with('category')->where('slug', $slug)->where('is_published', true)->first();

        if (! $blog) {
            return response()->json([
                'success' => false,
                'message' => 'Article not found.',
            ], 404);
        }

        $blog->increment('views_count');

        return response()->json([
            'success' => true,
            'data' => $blog,
        ]);
    }
}
