<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('division')->default('both'); // 'sales', 'service', 'both'
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('category');
            $table->text('short_description');
            $table->longText('description')->nullable();
            $table->json('features')->nullable();
            $table->string('icon')->default('wrench');
            $table->string('image_url')->nullable();
            $table->string('starting_price')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
