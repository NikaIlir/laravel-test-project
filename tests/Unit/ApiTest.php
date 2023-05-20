<?php
namespace Tests\Unit;

use App\Models\User;
use App\Models\Package;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ApiTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function a_user_can_register(): void
    {
        $userDetails = [
            'name' => 'Test User',
            'email' => 'testuser@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ];

        $response = $this->postJson('/api/register', $userDetails);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'success',
                'message',
                'data'
            ]);
    }

    /** @test */
    public function a_user_can_login(): void
    {
        $user = User::factory()->create();

        $loginDetails = [
            'email' => $user->email,
            'password' => 'password',
        ];

        $response = $this->postJson('/api/login', $loginDetails);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => ['token'],
            ]);
    }

    /** @test */
    public function a_user_can_list_packages(): void
    {
        $user = User::factory()->create();
        Package::factory()->count(15)->create();

        $response = $this->actingAs($user, 'sanctum')->getJson('/api/packages');

        $response->assertStatus(200)
            ->assertJsonCount(15, 'data')
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'uuid',
                        'name',
                        'is_available',
                    ],
                ],
            ]);
    }

    /** @test */
    public function a_user_can_make_registration_to_package()
    {
        $user = User::factory()->create();
        $package = Package::factory()->count(15)->create()->first();


        $response = $this->actingAs($user, 'sanctum')->postJson('/api/registration/' . $package->uuid);

        // Assert the user was created.
        $this->assertDatabaseHas('registrations', [
            'user_id' => $user->id,
            'package_id' => $package->id
        ]);

        // Assert the response was successful.
        $response->assertStatus(201);
    }
}
