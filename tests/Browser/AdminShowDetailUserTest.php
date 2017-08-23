<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\User;
use App\Order;

class AdminShowDetailUserTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * Test route view admin show detail user.
     *
     * @return void
     */
    public function testRouteShowDetailUser()
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

    /**
     * Test Route View Admin Show User Page.
     *
     * @return void
     */
    public function testShowUser()
    {
        $user = User::find(1);
        $this->browse(function (Browser $browser) use ($user) {
            $browser->visit('/users/' . $user->id)
                ->assertSee($user->id)
                ->assertSee($user->full_name)
                ->assertSee($user->email);
        });
    }

    public function testShowTotalOrders()
    {
        factory(Order::class, 5)->create();
        $this->browse(function (Browser $browser) {
            $browser->visit('/users/1')
                ->resize(1920, 1080);
            $elements = $browser->elements('#table-order-history tbody tr');
            $this->assertCount(5, $elements);
            $this->assertCount(0, $browser->elements('.pagination'));
        });
    }

    public function testShowRecordTotalOrders()
    {
        factory(Order::class, 15)->create();
        $this->browse(function (Browser $browser) {
            $browser->visit('users/1');
            $elements = $browser->elements('#table-order-history tbody tr');
            $this->assertCount(10, $elements);
            $this->assertNotNull($browser->elements('.pagination'));
        });
    }

    public function testTotalOrdersPagination()
    {
        factory(Order::class, 15)->create();
        $this->browse(function (Browser $browser) {
            $browser->visit('users/1?page=2');
            $elements = $browser->elements('#table-order-history tbody tr');
            $this->assertCount(5, $elements);
            $browser->assertPathIs('/users/1')
                ->assertQueryStringHas('page', 2);
        });
    }

    public function testShowDetail404Error()
    {
        factory(User::class, 5)->create();
        $user = User::find(4);
        $this->browse(function (Browser $browser) use ($user) {
            $browser->visit('/users');
            $user->delete();
            $browser->press('.table tbody tr:nth-child(4) td:nth-child(7) a:nth-child(1)');
            $browser->resize(1920, 1920)
                ->assertSee('404');
        });
    }
}
