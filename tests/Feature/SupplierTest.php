<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Supplier;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SupplierTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_access_suppliers_page(): void
    {
        $user = User::factory()->create([
            'role' => 'user',
        ]);

        Supplier::create([
            'name' => 'John Doe',
            'company_name' => 'Doe Inc.',
            'email' => 'john@example.com',
            'status' => 'active',
        ]);

        $response = $this->actingAs($user)->get(route('user.suppliers.index'));

        $response->assertStatus(200);
    }

    public function test_authenticated_user_can_access_supplier_profile_page(): void
    {
        $user = User::factory()->create([
            'role' => 'user',
        ]);

        $supplier = Supplier::create([
            'name' => 'John Doe',
            'company_name' => 'Doe Inc.',
            'email' => 'john@example.com',
            'status' => 'active',
        ]);

        $response = $this->actingAs($user)->get(route('user.suppliers.show', $supplier));

        $response->assertStatus(200);
    }
}
