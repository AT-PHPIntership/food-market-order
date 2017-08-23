<?php

namespace Tests\Browser;

use App\Category;
use App\User;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;

class ListCategoryTest extends DuskTestCase
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
                ->visit('/categories')
                ->assertSee('LIST CATEGORIES PAGE');
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
                ->visit('/categories')
                ->assertSee('LIST CATEGORIES PAGE');
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
            factory(Category::class,10)->create();
            $elements = $browser->visit('/categories')
                ->elements('.table tbody tr');
            $numRecord = count($elements);
            $this->assertTrue($numRecord == 10);

            // Test data have 12 record
            factory(Category::class,2)->create();
            // Page 1 table have 10 record
            $elements = $browser->visit('/categories')
                ->elements('.table tbody tr');
            $numRecord = count($elements);
            $this->assertTrue($numRecord == 10);
            // Page 2 table have 2 record
            $elements = $browser->visit('/categories?page=2')
                ->elements('.table tbody tr');
            $numRecord = count($elements);
            $this->assertTrue($numRecord == 2);
            // Page 3 not access
            $elements = $browser->visit('/categories?page=3')
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
            $browser->visit('/categories')
                ->click('#btn-add-category')
                ->assertPathIs('/categories/create');
        });
    }

    /**
     * Test button click Edit Category.
     *
     * @return void
     */
    public function testClickEdit()
    {
        factory(Category::class, 10)->create();
        $this->browse(function (Browser $browser) {
            // Click button add category
            $element = 'tbody tr:nth-child(2)';
            $id = $browser->visit('/categories')
                ->text($element. ' td');

            $browser->visit('/categories')
                ->click($element. ' .fa-edit')
                ->assertPathIs('/categories/'.$id.'/edit')->screenshot('abc2');
        });
    }


    /**
     * Test button click Add Category.
     *
     * @return void
     */
    public function testClickDelete()
    {
        factory(Category::class, 10)->create();
        $this->browse(function (Browser $browser) {
            // Click button add category
            $element = 'tbody tr:nth-child(2)';
            $id = $browser->visit('/categories')
                ->text($element. ' td');
            $browser->visit('/categories')
                ->click($element. ' .fa-trash')
                ->waitFor(null,3)
                ->assertSeeIn('#modal-confirm-title','Delete Category');
        });
    }
}
