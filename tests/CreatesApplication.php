<?php

namespace Tests;

use Illuminate\Contracts\Console\Kernel;
use App\Category;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use App\Category;

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
            'full_name' => 'DungVan',
            'email' => 'admin' . '@gmail.com',
            'password' => bcrypt('123456'),
            'is_admin' => 1,
        ]);
        factory(Category::class, 20)->create();
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
