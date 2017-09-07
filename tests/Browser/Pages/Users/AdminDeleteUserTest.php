<?php

namespace Tests\Browser;

use App\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Support\Facades\DB;

class AdminDeleteUserTest extends DuskTestCase
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
                ->resize(1920, 1080)
                ->visit('/users')
                ->assertSee("User's Table Data");
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
                ->resize(1920, 1080)
                ->visit('/users')
                ->click('#table tbody tr:nth-child(2) td:nth-child(7) button')
                ->waitFor(null, '1')
                ->assertSee('Delete User')
                ->assertSee('Are you sure to delete this user?')
                ->click('#btn-modal-submit')
                ->assertSee('Delete Successfully!');
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
                ->resize(1920, 1080)
                ->visit('/users')
                ->click('#table tbody tr:nth-child(1) td:nth-child(7) button')
                ->waitFor(null, '1')
                ->assertSee('Delete User')
                ->assertSee('Are you sure to delete this user?')
                ->click('#btn-modal-submit')
                ->assertSee('Cannot delete current user!');
        });
    }

    /**
     * A Dusk test delete success.
     *
     * @return void
     */
    public function testDeleteFail()
    {
        $this->browse(function (Browser $browser) {
            DB::table('users')->insert([
                'full_name' => 'test',
                'email' => 'test'.'@gmail.com',
                'password' => bcrypt('123456'),
                'is_admin' => 0,
            ]);
            $browser->loginAs(1)
                ->resize(1920, 1080)
                ->visit('/users');
            DB::table('users')->delete(2);
            $browser->click('#table tbody tr:nth-child(2) td:nth-child(7) button')
                ->waitFor(null, '1')
                ->assertSee('Delete User')
                ->assertSee('Are you sure to delete this user?')
                ->click('#btn-modal-submit')
                ->assertSee('Delete Error!');
        });
    }
}
