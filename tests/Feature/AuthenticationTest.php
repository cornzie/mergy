<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * A user can login and get a bearer token.
     *
     * @return void
     */
    public function test_a_user_can_get_access_token()
    {
        $user = User::factory()->create();

        $response = $this->post('api/login', [
            'email' => $user->email,
            'password' => 'password'
        ]);

        $response->assertStatus(200);
    }

    /**
     * A user can squash token.
     *
     * @return void
     */
    public function test_a_user_can_destroy_auth_token()
    {
        Sanctum::actingAs(
            $user = User::factory()->create(),
            ['*']
        );

        $response = $this->post('api/logout');

        $response->assertStatus(200);
    }
}
