<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Artisan;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
     * This function is called before testcase
     */
    public function setUp()
    {
        parent::setUp();
        Artisan::call('migrate:refresh');
        \DB::table('oauth_clients')->insert([
            'id'=> env('CLIENT_ID'),
            'name' => 'Food-Market-Order Password Grant Client',
            'secret' => env('CLIENT_SECRET'),
            'redirect' => 'http://localhost',
            'personal_access_client' => 0,
            'password_client' => 1,
            'revoked' => 0
        ]);
    }

    /**
     * This functin is called after testcase
     */
    public function tearDown()
    {
        Artisan::call('migrate:rollback');
        parent::tearDown();
    }

}
