<?php

namespace Tests\Browser;

use App\Order;
use App\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Support\Facades\DB;

class DeleteOrderTest extends DuskTestCase
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
                ->visit('/orders')
                ->assertSee("LIST ORDERS");
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
            factory(User::class, 10)->create();
            factory(Order::class, 5)->create();
            $browser->loginAs(1)
                ->resize(1920, 1080)
                ->visit('/orders')
                ->click( 'tbody tr:nth-child(2) .fa-trash')
                ->waitFor(null, '1')
                ->assertSee('Delete Order')
                ->assertSee('Are you want delete it?')
                ->click('#btn-modal-submit')
                ->assertSee('Delete Order Success');
        });
    }

    /**
     * A Dusk test delete fail.
     *
     * @return void
     */
    public function testDeleteFail()
    {
        $this->browse(function (Browser $browser) {
            factory(User::class, 10)->create();
            factory(Order::class, 5)->create();
            $browser->loginAs(1)
                ->visit('/orders');
            DB::table('orders')->delete(2);
            $browser->click('tbody tr:nth-child(2) .fa-trash')
                ->waitFor(null, '1')
                ->assertSee('Delete Order')
                ->assertSee('Are you want delete it?')
                ->click('#btn-modal-submit')
                ->assertSee('Order Not Found');
        });
    }
}
