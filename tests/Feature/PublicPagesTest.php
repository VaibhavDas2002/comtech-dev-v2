<?php

namespace Tests\Feature;

use App\Models\Blog;
use App\Models\Enquiry;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class PublicPagesTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_home_page_is_accessible(): void
    {
        $response = $this->get(route('home'));
        $response->assertOk();
        $response->assertSee('Comtech');
        $response->assertSee('CCTV Surveillance');
    }

    public function test_about_page_is_accessible(): void
    {
        $response = $this->get(route('about'));
        $response->assertOk();
        $response->assertSee('Comtech Information Services');
        $response->assertSee('Comtech Infosys');
    }

    public function test_services_page_is_accessible(): void
    {
        $response = $this->get(route('services'));
        $response->assertOk();
        $response->assertSee('Our IT Services');
    }

    public function test_products_page_is_accessible(): void
    {
        $response = $this->get(route('products'));
        $response->assertOk();
        $response->assertSee('IT Hardware');
        $response->assertSee('Software Store');
    }

    public function test_promotions_page_is_accessible(): void
    {
        $response = $this->get(route('promotions'));
        $response->assertOk();
        $response->assertSee('Promotions');
        $response->assertSee('Offers');
    }

    public function test_gallery_page_is_accessible(): void
    {
        $response = $this->get(route('gallery'));
        $response->assertOk();
        $response->assertSee('Deployments');
        $response->assertSee('Gallery');
    }

    public function test_blogs_page_is_accessible(): void
    {
        $response = $this->get(route('blogs'));
        $response->assertOk();
        $response->assertSee('Knowledge Base');
    }

    public function test_blog_detail_page_is_accessible(): void
    {
        $blog = Blog::where('is_published', true)->first();
        $this->assertNotNull($blog);

        $response = $this->get(route('blogs.show', $blog->slug));
        $response->assertOk();
        $response->assertSee($blog->title);
    }

    public function test_contact_page_is_accessible(): void
    {
        $response = $this->get(route('contact'));
        $response->assertOk();
        $response->assertSee('Contact');
        $response->assertSee('Support Hub');
    }

    public function test_contact_form_submits_enquiry_successfully(): void
    {
        Livewire::test('pages::public.contact')
            ->set('name', 'Ramesh Sen')
            ->set('phone', '9434112345')
            ->set('email', 'ramesh@example.com')
            ->set('type', 'service')
            ->set('message', 'Need 8 CCTV cameras installed for shop in Suri')
            ->call('submitEnquiry')
            ->assertSet('submitted', true)
            ->assertHasNoErrors();

        $this->assertDatabaseHas('enquiries', [
            'name' => 'Ramesh Sen',
            'phone' => '9434112345',
            'email' => 'ramesh@example.com',
        ]);

        $enquiry = Enquiry::where('phone', '9434112345')->first();
        $this->assertNotNull($enquiry);
        $this->assertStringStartsWith('COM-', $enquiry->ticket_number);
    }
}
