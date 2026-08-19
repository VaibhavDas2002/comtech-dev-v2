<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\Service;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ApiEndpointsTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_api_services_endpoint_returns_data(): void
    {
        $response = $this->getJson('/api/services');
        $response->assertOk();
        $response->assertJsonStructure([
            'success',
            'data' => [
                '*' => ['id', 'title', 'slug', 'category', 'short_description', 'starting_price'],
            ],
        ]);
    }

    public function test_api_single_service_endpoint(): void
    {
        $service = Service::where('is_active', true)->first();
        $this->assertNotNull($service);

        $response = $this->getJson("/api/services/{$service->slug}");
        $response->assertOk();
        $response->assertJsonPath('data.title', $service->title);
    }

    public function test_api_products_endpoint_returns_paginated_data(): void
    {
        $response = $this->getJson('/api/products');
        $response->assertOk();
        $response->assertJsonStructure([
            'success',
            'data' => [
                '*' => ['id', 'name', 'slug', 'price', 'in_stock'],
            ],
            'meta' => ['current_page', 'last_page', 'total'],
        ]);
    }

    public function test_api_single_product_endpoint(): void
    {
        $product = Product::where('is_active', true)->first();
        $this->assertNotNull($product);

        $response = $this->getJson("/api/products/{$product->slug}");
        $response->assertOk();
        $response->assertJsonPath('data.name', $product->name);
    }

    public function test_api_blogs_endpoint(): void
    {
        $response = $this->getJson('/api/blogs');
        $response->assertOk();
        $response->assertJsonStructure([
            'success',
            'data',
            'meta',
        ]);
    }

    public function test_api_promotions_endpoint(): void
    {
        $response = $this->getJson('/api/promotions');
        $response->assertOk();
        $response->assertJsonPath('success', true);
    }

    public function test_api_gallery_endpoint(): void
    {
        $response = $this->getJson('/api/gallery');
        $response->assertOk();
        $response->assertJsonPath('success', true);
    }

    public function test_api_testimonials_endpoint(): void
    {
        $response = $this->getJson('/api/testimonials');
        $response->assertOk();
        $response->assertJsonPath('success', true);
    }

    public function test_api_enquiry_submission(): void
    {
        $payload = [
            'name' => 'API Test Customer',
            'phone' => '9876500000',
            'email' => 'api.customer@example.com',
            'type' => 'general',
            'subject' => 'Enquiry via REST API',
            'message' => 'Testing the REST API endpoint for enquiry submission.',
            'urgency' => 'normal',
            'preferred_contact' => 'whatsapp',
        ];

        $response = $this->postJson('/api/enquiries', $payload);
        $response->assertCreated();
        $response->assertJsonStructure([
            'success',
            'message',
            'ticket_number',
            'data' => ['id', 'name', 'phone', 'ticket_number'],
        ]);

        $this->assertDatabaseHas('enquiries', [
            'name' => 'API Test Customer',
            'phone' => '9876500000',
        ]);
    }

    public function test_api_enquiry_validation_failure(): void
    {
        $payload = [
            'name' => 'A', // Too short
            'phone' => '',  // Missing
            'message' => '',
        ];

        $response = $this->postJson('/api/enquiries', $payload);
        $response->assertStatus(422);
        $response->assertJsonPath('success', false);
        $response->assertJsonStructure(['errors' => ['name', 'phone', 'message']]);
    }
}
