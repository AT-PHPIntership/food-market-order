<?php

namespace Tests\Browser;

use App\Category;
use App\Food;
use App\User;
use Tests\TestCase;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ListFoodTest extends DuskTestCase
{
    use DatabaseMigrations;
    /**
     * A Dusk test URL food list.
     *
     * @return void
     */
    public function testURL()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
            ->visit('/foods')
            ->assertPathIs('/foods')
            ->assertPathIsNot('/FOOD')
            ->assertSee('List Food');
        });
    }

    /**
     * A Dusk test show record with empty data.
     *
     * @return void
     */
    public function testListEmpty()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                ->visit('/foods')
                ->assertSee('List Food');
            $elements = $browser->elements('.table tbody tr');
            $this->assertCount(0, $elements);
            $this->assertNull($browser->element('.pagination'));
        });
    }

    /**
     * A Dusk test show record with table has data.
     *
     * @return void
     */
    public function testListHasRecord()
    {
        factory(Category::class, 20)->create();
        factory(Food::class, 10)->create();
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                ->visit('/foods')
                ->resize(1920, 2000)
                ->assertSee('List Food');
            $elements = $browser->elements('.table tbody tr');
            $this->assertCount(10, $elements);
            $this->assertNull($browser->element('.pagination'));
        });
    }

    /**
    * A Dusk test show records and paginate.
    *
    * @return void
    */
    public function testShowRecordPaginate()
    {
        factory(Category::class, 20)->create();
        factory(Food::class, 21)->create();
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                ->visit('/foods')
                ->resize(1920, 2000)
                ->assertSee('List Food');
            $elements = $browser->elements('.table tbody tr');
            $this->assertCount(10, $elements);
            $this->assertNotNull($browser->element('.pagination'));
            $paginateElement = $browser->elements('.pagination li');
            $numberPage = count($paginateElement)- 2;
            $this->assertTrue($numberPage == 3);
        });
    }

    /**
     * Test click link paginate
     *
     * @return void
     */
    public function testPathPagination()
    {
        factory(Category::class, 20)->create();
        factory(Food::class, 12)->create();
        $this->browse(function (Browser $browser) {
            $browser->visit('/foods?page=2');
            $elements = $browser->elements('.table tbody tr');
            $this->assertCount(2, $elements);
            $browser->assertQueryStringHas('page', 2);
        });
    }
}
