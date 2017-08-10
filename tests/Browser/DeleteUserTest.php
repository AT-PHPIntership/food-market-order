<?php

namespace Tests\Browser;

use App\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;

class DeleteUserTest extends DuskTestCase
{
    use DatabaseTransactions;

    /**
     * A Dusk test show content.
     *
     * @return void
     */
    public function testContent()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(1)
                ->visit('/users')
                ->assertSee("User's Table Data")
                ->screenshot('testContent');
        });
    }

    /**
     * A Dusk test delete success.
     *
     * @return void
     */
    public function testDeleteSuccess()
    {
        $this->browse(function (Browser $browser) {
            factory(User::class, 5)->create();
            $browser->loginAs(1)
                ->visit('/users')
                ->click('#btn-delete-2')
                ->acceptDialog()
                ->screenshot('testDeleteSuccess');
        });
    }

    /**
     * A Dusk test delete current admin user login.
     *
     * @return void
     */
    public function testDeleteCurrentUser()
    {
        $this->browse(function (Browser $browser) {
            factory(User::class, 5)->create();
            $browser->loginAs(1)
                ->visit('/users')
                ->click('#btn-delete-1')
                ->acceptDialog()
                ->screenshot('testDeleteCurrentUser');
        });
    }
}
