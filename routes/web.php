<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes (Comtech Website)
|--------------------------------------------------------------------------
*/
Route::livewire('/', 'pages::public.home')->name('home');
Route::livewire('/about', 'pages::public.about')->name('about');
Route::livewire('/services', 'pages::public.services')->name('services');
Route::livewire('/products', 'pages::public.products')->name('products');
Route::livewire('/promotions', 'pages::public.promotions')->name('promotions');
Route::livewire('/gallery', 'pages::public.gallery')->name('gallery');
Route::livewire('/blogs', 'pages::public.blogs')->name('blogs');
Route::livewire('/blogs/{slug}', 'pages::public.blog-detail')->name('blogs.show');
Route::livewire('/contact', 'pages::public.contact')->name('contact');

/*
|--------------------------------------------------------------------------
| Admin Panel Routes (Protected by Auth)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified'])->group(function () {
    Route::livewire('/dashboard', 'pages::admin.dashboard')->name('dashboard');
    Route::livewire('/admin/enquiries', 'pages::admin.enquiries')->name('admin.enquiries');
    Route::livewire('/admin/services', 'pages::admin.services')->name('admin.services');
    Route::livewire('/admin/products', 'pages::admin.products')->name('admin.products');
    Route::livewire('/admin/promotions', 'pages::admin.promotions')->name('admin.promotions');
    Route::livewire('/admin/blogs', 'pages::admin.blogs')->name('admin.blogs');
    Route::livewire('/admin/gallery', 'pages::admin.gallery')->name('admin.gallery');
    Route::livewire('/admin/testimonials', 'pages::admin.testimonials')->name('admin.testimonials');
});

require __DIR__.'/settings.php';
