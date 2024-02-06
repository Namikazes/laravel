<?php

namespace Tests\Feature\Login;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginTest extends TestCase
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

    public function test_login_valid_admin_user()
    {
        $password = 'test1111';
        $data = User::factory()->create();

        $response = $this->post('/login',[
            'email' => $data->email,
            'password' => $password,
        ]);

        $response->assertRedirect('/home');
        $this->assertAuthenticatedAs($data);
        $this->assertDatabaseHas(User::class,[
            'email' => $data['email']
        ]);
    }

    public function test_login_invalid_email_admin_user()
    {
        $password = 'test1111';

        $response = $this->from('/login')->post('/login', [
            'email' => 'fake',
            'password' => $password,
        ]);

        $response->assertRedirect('/login');
        $response->assertStatus(302);
        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    public function test_login_valid_user()
    {
        $user = User::factory()->create();
        $newPassword = 'custom_password';
        $user->update(['password' => bcrypt($newPassword)]);

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => $newPassword,
        ]);

        $response->assertRedirect('/home');
        $this->assertAuthenticatedAs($user);
    }

    public function test_login_invalid_password_user()
    {
        $data = User::factory()->create([
            'password' => bcrypt('test'),
        ]);

        $response = $this->from('/login')->post('/login', [
            'email' => $data->email,
            'password' => 'invalid-password',
        ]);

        $response->assertRedirect('/login');
        $response->assertStatus(302);
        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }
}
