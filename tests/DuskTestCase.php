<?php

namespace Tests;

use Laravel\Dusk\TestCase as BaseTestCase;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

abstract class DuskTestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
     * Prepare for Dusk test execution.
     *
     * @beforeClass
     * @return void
     */
    public static function prepare()
    {
        static::startChromeDriver();
    }

    /**
     * Create the RemoteWebDriver instance.
     *
     * @return \Facebook\WebDriver\Remote\RemoteWebDriver
     */
    protected function driver()
    {
        return RemoteWebDriver::create(
            'http://localhost:9515', DesiredCapabilities::chrome()
        );
    }

    /**
     * This function is called before testcase
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
