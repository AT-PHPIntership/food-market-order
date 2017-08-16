<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\User;

class ListUserTest extends DuskTestCase
{
    use DatabaseTransactions;
    use WithoutMiddleware;

    /**
     * A Dusk test route to page.
     *
     * @return void
     */
    public function testClickRoute()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(1)
                ->visit('dashboard')
                ->click('.sidebar-menu li:nth-child(3) a:nth-child(1)')
                ->click('.sidebar-menu li:nth-child(3) ul li:nth-child(1)')
                ->assertPathIs('/users')
                ->screenshot('testClickRoute');
        });
    }

    /**
     * A Dusk test show content.
     *
     * @return void
     */
    public function testContent()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/users')
                ->assertSee("User's Table Data");
        });
    }

    /**
     * A Dusk test show record with table has data.
     *
     * @return void
     */
    public function testShowRecord()
    {
        factory(User::class, 8)->create();
        $this->browse(function (Browser $browser) {
            $browser->visit('/users')
                ->resize(1920, 2000)
                ->assertSee("User's Table Data")->screenshot('testShowRecord');
            $elements = $browser->elements('#table tbody tr');
            $row = count($elements);
            $this->assertTrue($row == 9);
            $this->assertNull($browser->element('.pagination'));
        });
    }

    /**
     * A Dusk test show record with table has data and ensure pagnate.
     *
     * @return void
     */
    public function testShowRecordPagnate()
    {
        factory(User::class, 11)->create();
        $this->browse(function (Browser $browser) {
            $browser->visit('/users')
                ->resize(1920, 2000)
                ->assertSee("User's Table Data")->screenshot('testShowRecordPagnate');
            $elements = $browser->elements('#table tbody tr');
            $row = count($elements);
            $this->assertTrue($row == 10);
            $this->assertNotNull($browser->element('.pagination'));
        });
    }

    /**
     * Test click page 2 in pagination link
     *
     * @return void
     */
    public function testPathPagination()
    {
        factory(User::class, 11)->create();
        $this->browse(function (Browser $browser) {
            $browser->visit('/users?page=2');
            $elements = $browser->elements('#table tbody tr');
            $this->assertCount(2, $elements);
            $browser->assertPathIs('/users');
            $browser->assertQueryStringHas('page', 2);
        });
    }
}
