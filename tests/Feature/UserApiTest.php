<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class UserApiTest extends TestCase
{
    use DatabaseTransactions;

    private $token;

    /**
     * A basic test login api.
     *
     * @return void
     */
    public function testLoginSuccess()
    {
        $response = $this->json('POST', '/api/users/login', ['email' => 'admin@gmail.com', 'password' => '123456']);
        $response->assertJsonStructure([
            'data' => [
                'token_type', 'expires_in', 'access_token', 'refresh_token'
            ],
            'success'
        ])->assertStatus(200);
    }

    /**
     * test login missing email or password
     *
     * @return void
     */
    public function testLoginMissingParameter()
    {
        $response = $this->json('POST', '/api/users/login', ['password' => '123456']);
        $response->assertJsonStructure(['error', 'message', 'hint'])
            ->assertStatus(400);
        $response = $this->json('POST', '/api/users/login', ['email' => 'admin@gmail.com']);
        $response->assertJsonStructure(['error', 'message', 'hint'])
            ->assertStatus(400);
    }

    /**
     * test login fail email or password
     *
     * @return void
     */
    public function testLoginFail()
    {
        $response = $this->json('POST', '/api/users/login', ['email' => 'testfail@gmail.com', 'password' => '123456']);
        $response->assertJsonStructure(['error', 'message'])
            ->assertStatus(401);
    }

    /**
     * test register success
     *
     * @return void
     */
    public function testRegisterSuccess()
    {
        $data = [
            'full_name' => 'test register',
            'email' => 'testregister@gmail.com',
            'password' => '123456',
            'password_confirmation' => '123456'
        ];
        $response = $this->json('POST', '/api/users', $data);
        $response->assertJsonStructure([
            'data' => [
                'email',
                'full_name',
                'updated_at',
                'created_at', 'id'
            ],
            'success'
        ])->assertStatus(200);
    }

    /**
     * test required field register
     *
     * @return void
     */
    public function testRequiredDataRegisterValidation()
    {
        $data = [];
        $response = $this->json('POST', '/api/users', $data);
        $response->assertJson([
            'full_name' => [
                'The full name field is required.'
            ],
            'email' => [
                'The email field is required.'
            ],
            'password' => [
                'The password field is required.'
            ]
        ])->assertStatus(422);
    }

    public function listCaseTestValidationForRegisterUser()
    {
        return [
            [
                [
                    'full_name' => '',
                    'email' => 'test.user@gmail.com',
                    'password' => '123456',
                    'password_confirmation' => '123456'],
                [
                    'full_name' => ['The full name field is required.']
                ]
            ],
            [
                [
                    'full_name' => 'test register',
                    'email' => '',
                    'password' => '123456',
                    'password_confirmation' => '123456'
                ],
                [
                    'email' => ['The email field is required.']
                ]
            ],
            [
                [
                    'full_name' => 'test register',
                    'email' => 'admin@gmail.com',
                    'password' => '123456',
                    'password_confirmation' => '123456'
                ],
                [
                    'email' => ['The email has already been taken.']
                ]
            ],
            [
                [
                    'full_name' => 'test register',
                    'email' => 'test.user.gmail.com',
                    'password' => '123456',
                    'password_confirmation' => '123456'
                ],
                [
                    'email' => ['The email must be a valid email address.']
                ]
            ],
            [
                [
                    'full_name' => 'test register',
                    'email' => 'test.user@gmail.com',
                    'password' => '12345', 'password_confirmation' => '12345'
                ],
                [
                    'password' => ['The password must be at least 6 characters.']
                ]
            ],
            [
                [
                    'full_name' => 'test register',
                    'email' => 'test.user@gmail.com',
                    'password' => '123457',
                    'password_confirmation' => '123456'
                ],
                [
                    'password' => ['The password confirmation does not match.']
                ]
            ]
        ];
    }

    /**
     * @dataProvider listCaseTestValidationForRegisterUser
     *
     * @return void
     */
    public function testRegisterUserFailValidation(
        $data,
        $expected
    )
    {
        $response = $this->json('POST', '/api/users', $data);
        $response->assertJson($expected)->assertStatus(422);
    }

    public function testShowUser()
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
        $response = $this->json('GET', '/api/users/me', [], $header);
        $response->assertJsonStructure([
            'data' => [
                'id', 'full_name', 'email', 'birthday', 'gender', 'address', 'phone_number', 'image',
                'is_admin', 'is_active', 'created_at', 'updated_at', 'deleted_at'
            ],
            'success'
        ])->assertStatus(200);
    }

    public function listCaseTestValidationForUpdateUser()
    {
        return [
            [
                [
                    'password' => '123',
                    'password_confirmation' => '123',
                    'full_name' => 'test user',
                    'gender' => '1',
                    'phone_number' => '12345678',
                    'address' => 'test address',
                    'birthday' => '2017-02-23'
                ],
                [
                    'password' => ['The password must be at least 6 characters.']
                ]
            ],
            [
                [
                    'password' => '123456',
                    'password_confirmation' => '123457',
                    'full_name' => 'test user',
                    'gender' => '1',
                    'phone_number' => '12345678',
                    'address' => 'test address',
                    'birthday' => '2017-02-23'
                ],
                [
                    'password' => ['The password confirmation does not match.']
                ]
            ],
            [
                [
                    'password' => '',
                    'password_confirmation' => '',
                    'full_name' => '',
                    'gender' => '1',
                    'phone_number' => '12345678',
                    'address' => 'test address',
                    'birthday' => '2017-02-23'
                ],
                [
                    'full_name' => ['The full name field is required.']
                ]
            ],
            [
                [
                    'password' => '',
                    'password_confirmation' => '',
                    'full_name' => 'test user',
                    'gender' => '1',
                    'phone_number' => '',
                    'address' => 'test address',
                    'birthday' => '2017-02-23'
                ],
                [
                    'phone_number' => ['The phone number field is required.']
                ]
            ],
            [
                [
                    'password' => '',
                    'password_confirmation' => '',
                    'full_name' => 'test user',
                    'gender' => '1',
                    'phone_number' => 'abcdefgh',
                    'address' => 'test address',
                    'birthday' => '2017-02-23'
                ],
                [
                    'phone_number' => ['The phone number must be a number.']
                ]
            ],
            [
                [
                    'password' => '',
                    'password_confirmation' => '',
                    'full_name' => 'test user',
                    'gender' => '1',
                    'phone_number' => '12345678',
                    'address' => '',
                    'birthday' => '2017-02-23'
                ],
                [
                    'address' => ['The address field is required.']
                ]
            ],
            [
                [
                    'password' => '',
                    'password_confirmation' => '',
                    'full_name' => 'test user',
                    'gender' => '1',
                    'phone_number' => '12345678',
                    'address' => 'test address',
                    'birthday' => ''
                ],
                [
                    'birthday' => ['The birthday is not a valid date.']
                ]
            ],
        ];
    }


    /**
     * @dataProvider listCaseTestValidationForUpdateUser
     *
     */
    public function testUpdateUserFailValidation(
        $data,
        $expected
    )
    {
        $datalogin = [
            'email' => 'admin@gmail.com',
            'password' => '123456'
        ];

        $response = $this->json('POST', '/api/users/login', $datalogin);
        $token = $response->getOriginalContent()['data'];
        $header = [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'Authorization' => $token['token_type'] . ' ' . $token['access_token']
        ];
        $response = $this->json('PUT', '/api/users/me', $data, $header);
        $response->assertJson($expected)->assertStatus(422);
    }
}
