<?php

namespace Tests\Feature;

use App\DailyMenu;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class OrderApiTest extends TestCase
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
            'email' => 'admin@gmail.com',
            'password' => '123456'
        ];

        $response = $this->json('POST', '/api/users/login', $data);
        $token = $response->getOriginalContent()['data'];
        $header = [
            'Accept' => 'application/json',
            'Authorization' => $token['token_type'] . ' ' . $token['access_token']
        ];
        factory(DailyMenu::class, 1)->create(['food_id' => 45, 'quantity' => 10, 'date' => Carbon::now()->toDateString()]);
        factory(DailyMenu::class, 1)->create(['food_id' => 3, 'quantity' => 10,  'date' => Carbon::now()->toDateString()]);
        $data = [
            'user_id'=> 1,
	        'address_ship'=> '33 Trần Quý Cáp',
	        'trans_at'=> Carbon::now()->toDateString(),
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
        $response = $this->json('POST', '/api/orders', $data, $header);
        $response->assertJsonStructure([
            'data' => [
                'order_id', 'user_id', 'address_ship', 'total_price'
            ],
            'success'
        ])->assertStatus(200);
        $data = json_decode($response->getContent());
        $arrayCompare = [
            'id' => $data->data->order_id,
            'user_id' => $data->data->user_id,
            'custom_address' => $data->data->address_ship,
            'total_price' => $data->data->total_price
        ];
        $this->assertDatabaseHas('orders', $arrayCompare);
    }

    public function listCaseTestValidationForCreateOrder()
    {
        return [
            [
                [
                    'user_id'=> '',
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
                ],
                [
                    'user_id' => ['The user id field is required.']
                ]
            ],
            [
                [
                    'user_id'=> 1,
                    'address_ship'=> '',
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
                ],
                [
                    'address_ship' => ['The address ship field is required.']
                ]
            ],
            [
                [
                    'user_id'=> 1,
                    'address_ship'=> '33 Trần Quý Cáp',
                    'trans_at'=> '',
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
                ],
                [
                    'trans_at' => ['The trans at field is required.']
                ]
            ],
            [
                [
                    'user_id'=> 1,
                    'address_ship'=> '33 Trần Quý Cáp',
                    'trans_at'=> '2017-09-12 11:11:00',
                    'type'=> '',
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
                ],
                [
                    'type' => ['The type field is required.']
                ]
            ],
            [
                [
                    'user_id'=> 1,
                    'address_ship'=> '33 Trần Quý Cáp',
                    'trans_at'=> '2017-09-12 11:11:00',
                    'type'=> '',
                    'items'=> ''
                ],
                [
                    'items' => ['The items field is required.']
                ]
            ]
        ];
    }

    /**
     * A basic test create order api valid validation.
     * @dataProvider listCaseTestValidationForCreateOrder
     *
     * @return void
     */
    public function testValidationCreateOrder($data, $expected)
    {
        $dataLogin = [
            'email' => 'admin@gmail.com',
            'password' => '123456'
        ];

        $response = $this->json('POST', '/api/users/login', $dataLogin);
        $token = $response->getOriginalContent()['data'];
        $header = [
            'Accept' => 'application/json',
            'Authorization' => $token['token_type'] . ' ' . $token['access_token']
        ];
        $response = $this->json('POST', '/api/orders', $data, $header);
        $response->assertJson($expected)->assertStatus(422);
    }

    /**
     * A basic test create order api fail quantity.
     *
     * @return void
     */
    public function testCreateOrderFailQuantity()
    {
        $dataLogin = [
            'email' => 'admin@gmail.com',
            'password' => '123456'
        ];

        $response = $this->json('POST', '/api/users/login', $dataLogin);
        $token = $response->getOriginalContent()['data'];
        $header = [
            'Accept' => 'application/json',
            'Authorization' => $token['token_type'] . ' ' . $token['access_token']
        ];
        factory(DailyMenu::class, 1)->create(['food_id' => 45, 'quantity' => 3, 'date' => Carbon::now()->toDateString()]);
        factory(DailyMenu::class, 1)->create(['food_id' => 3, 'quantity' => 1,  'date' => Carbon::now()->toDateString()]);
        $data = [
            'user_id'=> 1,
            'address_ship'=> '33 Trần Quý Cáp',
            'trans_at'=> Carbon::now()->toDateString(),
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
        $response = $this->json('POST', '/api/orders', $data, $header);
        $response->assertJsonStructure([
            'message'
        ])->assertSee('SQLSTATE')->assertStatus(404);
    }
}
