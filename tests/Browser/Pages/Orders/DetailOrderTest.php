<?php

namespace Tests\Browser;

use App\Category;
use App\Food;
use App\Material;
use App\Order;
use App\OrderItem;
use App\Supplier;
use App\User;
use Illuminate\Support\Facades\DB;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;

class DetailOrderTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testURL()
    {
        $this->browse(function (Browser $browser) {
            factory(Order::class,10)->create();
            $order = Order::find(1);
            $browser->loginAs(User::find(1))
                ->visit('/orders/1')
                ->assertSee('DETAIL ORDERS')
                ->assertSeeIn('.box-header .box-title','Order '.$order->id.' - Date : '.$order->created_at);
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
            factory(Order::class,10)->create();
            $browser->loginAs(User::find(1))
                ->visit('/orders/1')
                ->assertSee('DETAIL ORDERS');
            $elements = $browser->elements('.dataTable tbody tr');
            $numRecord = count($elements);
            $this->assertTrue($numRecord == 0);
        });
    }

    /**
     * Test list data.
     *
     * @return void
     */
    public function testDataExist()
    {
        $this->browse(function (Browser $browser) {
            // Test data have 10 record
            factory(Order::class,10)->create();
            factory(Category::class,10)->create();
            factory(Supplier::class,10)->create();
            factory(Food::class,10)->create();
            factory(Material::class,10)->create();
            factory(OrderItem::class,10)->create(['order_id' => 1,]);
            $elements = $browser->visit('/orders/1')
                ->elements('.dataTable tbody tr');
            $numRecord = count($elements);
            $this->assertTrue($numRecord == 10);
        });
    }

    /**
     * Test update item success.
     *
     * @return void
     */
    public function testUpdateItemSuccess()
    {
        $this->browse(function (Browser $browser) {
            // Test data have 10 record
            factory(Order::class,10)->create();
            factory(Category::class,10)->create();
            factory(Supplier::class,10)->create();
            factory(Food::class,10)->create();
            factory(Material::class,10)->create();
            factory(OrderItem::class,10)->create(['order_id' => 1,]);
            $browser->loginAs(User::find(1))
                ->resize(1920, 1080)
                ->visit('/orders/1')
                ->assertSee('DETAIL ORDERS')
                ->type('quantity',9)
                ->click('.box-body')
                ->waitFor(null,5)
                ->click('#btn-modal-submit')
                ->waitForText('Update Item 1 Success');
        });
    }

    /**
     * Test delete item success.
     *
     * @return void
     */
    public function testDeleteItemSuccess()
    {
        $this->browse(function (Browser $browser) {
            // Test data have 10 record
            factory(Order::class,10)->create();
            factory(Category::class,10)->create();
            factory(Supplier::class,10)->create();
            factory(Food::class,10)->create();
            factory(Material::class,10)->create();
            factory(OrderItem::class,10)->create(['order_id' => 1,]);
            $element = '.dataTable tbody tr:nth-child(1)';
            $browser->loginAs(User::find(1))
                ->resize(1920, 1080)
                ->visit('/orders/1')
                ->assertSee('DETAIL ORDERS')
                ->click($element. ' .delete-order-item')
                ->waitFor(null,10)
                ->click('#btn-modal-submit')
                ->waitForText('Delete Item 1 Success');
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
            factory(Category::class, 5)->create();
            $browser->loginAs(1)
                ->resize(1920, 1080)
                ->visit('/categories');

            // Test data have 10 record
            factory(Order::class,10)->create();
            factory(Category::class,10)->create();
            factory(Supplier::class,10)->create();
            factory(Food::class,10)->create();
            factory(Material::class,10)->create();
            factory(OrderItem::class,10)->create(['order_id' => 1,]);
            $browser->loginAs(User::find(1))
                ->resize(1920, 1080)
                ->visit('/orders/1')
                ->assertSee('DETAIL ORDERS')->screenshot('sss');
            $element = '.dataTable tbody tr:nth-child(1)';
            $id_item = $browser ->text($element. ' td');
            echo $id_item;
            DB::table('order_items')->delete($id_item);
                $browser->click($element. ' .delete-order-item')
                ->waitFor(null,10)
                ->click('#btn-modal-submit')
                ->waitForText('Order Item Not Found');
        });
    }
}
