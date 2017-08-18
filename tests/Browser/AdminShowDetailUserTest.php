<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class AdminShowDetailUserTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * Test route view admin show detail user.
     *
     * @return void
     */
    public function testShowDetailUser()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(1)
                ->visit('/users')
                ->click('.table tbody tr:nth-child(1) td:nth-child(7) a:nth-child(1)')
                ->assertPathIs('/users/1')
                ->assertSee('DETAIL USER')
                ->assertSee('User Information');
        });
    }

}
