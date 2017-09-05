<?php

namespace Tests\Browser;

use App\Order;
use App\User;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class OrderListTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testURL()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                ->visit('/orders')
                ->assertSee('LIST ORDERS');
        });
    }

    /**
     * Test data empty.
     *
     * @return void
     */
    public function testDataEmpty()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                ->visit('/orders')
                ->assertSee('LIST ORDERS');
            $elements = $browser->elements('.table tbody tr');
            $numRecord = count($elements);
            $this->assertTrue($numRecord == 0);
        });
    }

    /**
     * Test pagination.
     *
     * @return void
     */
    public function testPagination()
    {
        $this->browse(function (Browser $browser) {
            // Test data have 10 record
            factory(Order::class,10)->create();
            $elements = $browser->visit('/orders')
                ->elements('.table tbody tr');
            $numRecord = count($elements);
            $this->assertTrue($numRecord == 10);

            // Test data have 12 record
            factory(Order::class,2)->create();
            // Page 1 table have 10 record
            $elements = $browser->visit('/orders')
                ->elements('.table tbody tr');
            $numRecord = count($elements);
            $this->assertTrue($numRecord == 10);
            // Page 2 table have 2 record
            $elements = $browser->visit('/orders?page=2')
                ->elements('.table tbody tr');
            $numRecord = count($elements);
            $this->assertTrue($numRecord == 2);
            // Page 3 not access
            $elements = $browser->visit('/orders?page=3')
                ->elements('.table tbody tr');
            $numRecord = count($elements);
            $this->assertTrue($numRecord == 0);
        });
    }

    /**
     * Test button click Detail Order.
     *
     * @return void
     */
    public function testClickDetail()
    {
        factory(Order::class, 10)->create();
        $this->browse(function (Browser $browser) {
            // Click button add category
            $element = 'tbody tr:nth-child(2)';
            $id = $browser->visit('/orders')
                ->text($element. ' td');

            $browser->visit('/orders')
                ->click($element. ' .btn-info')
                ->assertPathIs('/orders/'.$id);
        });
    }

    /**
     * Test Select Status Order.
     *
     * @return void
     */
    public function testSelectStatus()
    {
        factory(Order::class, 10)->create();
        $this->browse(function (Browser $browser) {
            // Click button add category
            $element = 'tbody tr:nth-child(2)';
            $id = $browser->visit('/orders')
                ->text($element. ' td');
            $browser->visit('/orders')
                ->select('.status-order',2)
                ->waitFor(null,3)
                ->assertSeeIn('#modal-confirm-title','Change Status');

        });
    }

    /**
     * Test button click Delete Order.
     *
     * @return void
     */
    public function testClickDelete()
    {
        factory(Order::class, 10)->create();
        $this->browse(function (Browser $browser) {
            // Click button add category
            $element = 'tbody tr:nth-child(2)';
            $id = $browser->visit('/orders')
                ->text($element. ' td');
            $browser->visit('/orders')
                ->click($element. ' .btn-danger')
                ->waitFor(null,3)
                ->assertSeeIn('#modal-confirm-title','Delete Order');
        });
    }
}
