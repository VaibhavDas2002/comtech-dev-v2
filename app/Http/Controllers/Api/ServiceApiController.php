<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ServiceApiController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = Service::query()->where('is_active', true)->orderBy('sort_order');

        if ($request->filled('category')) {
            $query->where('category', $request->query('category'));
        }

        if ($request->filled('division')) {
            $query->where(function ($q) use ($request): void {
                $q->where('division', $request->query('division'))
                    ->orWhere('division', 'both');
            });
        }

        if ($request->filled('search')) {
            $search = $request->query('search');
            $query->where(function ($q) use ($search): void {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('short_description', 'like', "%{$search}%")
                    ->orWhere('category', 'like', "%{$search}%");
            });
        }

        $services = $query->get();

        return response()->json([
            'success' => true,
            'data' => $services,
        ]);
    }

    public function show(string $slug): JsonResponse
    {
        $service = Service::query()->where('slug', $slug)->where('is_active', true)->first();

        if (! $service) {
            return response()->json([
                'success' => false,
                'message' => 'Service not found.',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $service,
        ]);
    }
}
