<?php

namespace Tests\Feature\Registration;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        $this->app->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();
    }

    protected function afterRefreshingDatabase(): void
    {
        $this->seed();
    }

    public function test_check_valid_registretion()
    {
        $data = [
            'name' => $this->faker->firstName,
            'surname' => $this->faker->lastName,
            'email' => $this->faker->unique()->safeEmail,
            'phone' => $this->faker->unique()->phoneNumber,
            'birthdate' => $this->faker->dateTimeBetween('-50 years', '-18 years')->format('Y-m-d'),
            'password' => 'password',
            'password_confirmation' => 'password',
        ];

        $response = $this->post('/register', $data);

        $response->assertStatus(302);
        $response->assertRedirect('/home');

        $this->assertAuthenticated();
        $this->assertDatabaseHas(User::class, [
            'name' => $data['name']
        ]);
    }

    public function test_check_invalid_registretion()
    {
        $data = [
            'name' => 'q',
            'surname' => $this->faker->lastName,
            'email' => $this->faker->unique()->safeEmail,
            'phone' => $this->faker->unique()->phoneNumber,
            'birthdate' => $this->faker->dateTimeBetween('-50 years', '-18 years')->format('Y-m-d'),
            'password' => 'password',
            'password_confirmation' => 'password',
        ];

        $response = $this->post('/register', $data);

        $this->assertGuest();

        $response->assertStatus(302);
        $response->assertSessionHasErrors(['name']);
        $this->assertDatabaseMissing(User::class, [
            'name' => $data['name']
        ]);
    }
}
