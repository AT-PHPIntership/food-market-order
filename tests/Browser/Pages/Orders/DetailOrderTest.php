<?php

namespace Tests\Browser;

use App\Category;
use App\Food;
use App\Material;
use App\Order;
use App\OrderItem;
use App\Supplier;
use App\User;
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
                ->assertSeeIn('.box-header .box-title','Orders '.$order->id.' - Date : '.$order->created_at);
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
            echo $numRecord;
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
     * Test button click Add Category.
     *
     * @return void
     */
//    public function testClickAdd()
//    {
//        $this->browse(function (Browser $browser) {
//            $browser->visit('/categories')
//                ->click('#btn-add-category')
//                ->assertPathIs('/categories/create');
//        });
//    }

    /**
     * Test button click Edit Category.
     *
     * @return void
     */
//    public function testClickEdit()
//    {
//        factory(Category::class, 10)->create();
//        $this->browse(function (Browser $browser) {
//            // Click button add category
//            $element = 'tbody tr:nth-child(2)';
//            $id = $browser->visit('/categories')
//                ->text($element. ' td');
//
//            $browser->visit('/categories')
//                ->click($element. ' .fa-edit')
//                ->assertPathIs('/categories/'.$id.'/edit')->screenshot('abc2');
//        });
//    }


    /**
     * Test button click Add Category.
     *
     * @return void
     */
//    public function testClickDelete()
//    {
//        factory(Category::class, 10)->create();
//        $this->browse(function (Browser $browser) {
//            // Click button add category
//            $element = 'tbody tr:nth-child(2)';
//            $id = $browser->visit('/categories')
//                ->text($element. ' td');
//            $browser->visit('/categories')
//                ->click($element. ' .fa-trash')
//                ->waitFor(null,3)
//                ->assertSeeIn('#modal-confirm-title','Delete Category');
//        });
//    }
}
