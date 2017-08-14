<?php

namespace Tests;

use Illuminate\Contracts\Console\Kernel;
use Illuminate\Support\Facades\Artisan;
use App\User;
use Illuminate\Support\Facades\DB;

trait CreatesApplication
{
    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        $app = require __DIR__.'/../bootstrap/app.php';

        $app->make(Kernel::class)->bootstrap();

        $app['config']->set('database.default','testing');

        return $app;
    }

    /**
     * This functin is called before testcase
     */
    public function setUp()
    {
        parent::setUp();
        Artisan::call('migrate');

        DB::table('users')->insert([
            'full_name' => 'Testing',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('123456'),
            'is_admin' => 1,
        ]);
    }

    /**
     * This function is called after testcase
     */
    public function tearDown()
    {
        Artisan::call('migrate:rollback');
        parent::tearDown();
    }
}
