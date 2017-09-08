<?php

namespace Tests\Browser;

use App\Supplier;
use App\User;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class ListSuppilerTest extends DuskTestCase
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
                ->visit('/suppliers')
                ->assertSee('LIST SUPPLIERS');
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
                ->visit('/suppliers')
                ->assertSee('LIST SUPPLIERS');
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
            factory(Supplier::class,10)->create();
            $elements = $browser->visit('/suppliers')
                ->elements('.table tbody tr');
            $numRecord = count($elements);
            $this->assertTrue($numRecord == 10);

            // Test data have 12 record
            factory(Supplier::class,2)->create();
            // Page 1 table have 10 record
            $elements = $browser->visit('/suppliers')
                ->elements('.table tbody tr');
            $numRecord = count($elements);
            $this->assertTrue($numRecord == 10);
            // Page 2 table have 2 record
            $elements = $browser->visit('/suppliers?page=2')
                ->elements('.table tbody tr');
            $numRecord = count($elements);
            $this->assertTrue($numRecord == 2);
            // Page 3 not access
            $elements = $browser->visit('/suppliers?page=3')
                ->elements('.table tbody tr');
            $numRecord = count($elements);
            $this->assertTrue($numRecord == 0);
        });
    }

    /**
     * Test button click Add Category.
     *
     * @return void
     */
    public function testClickAdd()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/suppliers')
                ->click('#btn-add-supplier')
                ->assertPathIs('/suppliers/create');
        });
    }

    /**
     * Test button click Edit Category.
     *
     * @return void
     */
    public function testClickEdit()
    {
        factory(Supplier::class, 10)->create();
        $this->browse(function (Browser $browser) {
            // Click button add category
            $element = 'tbody tr:nth-child(2)';
            $id = $browser->visit('/suppliers')
                ->text($element. ' td');

            $browser->visit('/suppliers')
                ->click($element. ' .fa-edit')
                ->assertPathIs('/suppliers/'.$id.'/edit');
        });
    }


    /**
     * Test button click Add Category.
     *
     * @return void
     */
    public function testClickDelete()
    {
        factory(Supplier::class, 10)->create();
        $this->browse(function (Browser $browser) {
            // Click button add category
            $element = 'tbody tr:nth-child(2)';
            $id = $browser->visit('/suppliers')
                ->text($element. ' td');
            $browser->visit('/suppliers')
                ->click($element. ' .fa-trash')
                ->waitForText('Delete Supplier')
                ->assertSee('Are you want delete it?');
        });
    }
}