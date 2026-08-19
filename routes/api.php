<?php

use App\Http\Controllers\Api\BlogApiController;
use App\Http\Controllers\Api\EnquiryApiController;
use App\Http\Controllers\Api\GalleryApiController;
use App\Http\Controllers\Api\ProductApiController;
use App\Http\Controllers\Api\PromotionApiController;
use App\Http\Controllers\Api\ServiceApiController;
use App\Http\Controllers\Api\TestimonialApiController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Comtech REST APIs (Headless / External Applications)
|--------------------------------------------------------------------------
*/

Route::prefix('v1')->group(function () {
    // Services Endpoints
    Route::get('/services', [ServiceApiController::class, 'index']);
    Route::get('/services/{slug}', [ServiceApiController::class, 'show']);

    // Products Endpoints
    Route::get('/products', [ProductApiController::class, 'index']);
    Route::get('/products/{slugOrId}', [ProductApiController::class, 'show']);

    // Blogs Endpoints
    Route::get('/blogs', [BlogApiController::class, 'index']);
    Route::get('/blogs/{slug}', [BlogApiController::class, 'show']);

    // Promotions & Deals
    Route::get('/promotions', [PromotionApiController::class, 'index']);

    // Gallery
    Route::get('/gallery', [GalleryApiController::class, 'index']);

    // Testimonials
    Route::get('/testimonials', [TestimonialApiController::class, 'index']);

    // Lead Capture / Enquiry Submission
    Route::post('/enquiries', [EnquiryApiController::class, 'store']);
});

// Fallback direct aliases (without /v1)
Route::get('/services', [ServiceApiController::class, 'index']);
Route::get('/services/{slug}', [ServiceApiController::class, 'show']);
Route::get('/products', [ProductApiController::class, 'index']);
Route::get('/products/{slugOrId}', [ProductApiController::class, 'show']);
Route::get('/blogs', [BlogApiController::class, 'index']);
Route::get('/blogs/{slug}', [BlogApiController::class, 'show']);
Route::get('/promotions', [PromotionApiController::class, 'index']);
Route::get('/gallery', [GalleryApiController::class, 'index']);
Route::get('/testimonials', [TestimonialApiController::class, 'index']);
Route::post('/enquiries', [EnquiryApiController::class, 'store']);
