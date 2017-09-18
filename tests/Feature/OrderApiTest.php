<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class UserApiTest extends TestCase
{
    use DatabaseTransactions;


    /**
     * A basic test create order api success.
     *
     * @return void
     */
    public function testCreateOrderSuccess()
    {
        $data = [
            'user_id'=> 1,
	        'address_ship'=> '33 Trần Quý Cáp',
	        'trans_at'=> '2017-09-12 11:11:00',
	        'type'=> 'App\Food',
	        'items'=> [
                [
                    'id' => 45,
                    'quantity' => 4
                ],
                [
                    'id' => 3,
                    'quantity' => 1
                ]
	        ]
        ];
        $response = $this->json('POST', '/api/orders/', $data);
        $response->assertJsonStructure([
            'data' => [
                'token_type', 'expires_in', 'access_token', 'refresh_token'
            ],
            'success'
        ])->assertStatus(200);
    }
}
