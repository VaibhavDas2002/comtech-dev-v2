<?php

namespace Tests\Feature;

use App\Models\Enquiry;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class AdminManagementTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_guest_is_redirected_from_dashboard(): void
    {
        $response = $this->get(route('dashboard'));
        $response->assertRedirect(route('login'));
    }

    public function test_authenticated_admin_can_view_dashboard(): void
    {
        $user = User::first();
        $this->assertNotNull($user);

        $response = $this->actingAs($user)->get(route('dashboard'));
        $response->assertOk();
        $response->assertSee('Business Control Center');
        $response->assertSee('Customer Enquiries');
    }

    public function test_admin_can_manage_services(): void
    {
        $user = User::first();

        Livewire::actingAs($user)
            ->test('pages::admin.services')
            ->set('title', 'Cloud Server Migration')
            ->set('category', 'Cloud IT')
            ->set('division', 'service')
            ->set('short_description', 'Migrate on-premise servers to AWS or Azure cloud.')
            ->set('starting_price', '₹15,000')
            ->call('save')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('services', [
            'title' => 'Cloud Server Migration',
            'category' => 'Cloud IT',
        ]);
    }

    public function test_admin_can_update_enquiry_status(): void
    {
        $user = User::first();
        $enquiry = Enquiry::create([
            'name' => 'Test Lead',
            'phone' => '9876543210',
            'message' => 'Testing enquiry status update',
            'status' => 'pending',
        ]);

        Livewire::actingAs($user)
            ->test('pages::admin.enquiries')
            ->call('updateStatus', $enquiry->id, 'contacted');

        $this->assertEquals('contacted', $enquiry->fresh()->status);
    }
}
