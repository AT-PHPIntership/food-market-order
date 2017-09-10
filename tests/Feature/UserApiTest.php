<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class UserApiTest extends TestCase
{
    use DatabaseMigrations;

    private $token;

    /**
     * A basic test login api.
     *
     * @return void
     */
    public function testLoginSuccess()
    {
        $response = $this->json('POST', '/users/login', ['email' => 'admin@gmail.com', 'password' => '123456']);
        $response->assertJsonStructure([
            'data' => [
                'token_type', 'expires_in', 'access_token', 'refresh_token'
            ],
            'success'
        ])->assertStatusOk();
    }
}
