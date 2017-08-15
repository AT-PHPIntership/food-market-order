<?php

namespace Tests\Browser;

use App\Food;
use App\User;
use Tests\TestCase;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Support\Facades\DB;

class ListFoodTest extends DuskTestCase
{
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
            ->assertPathIsNot('/home')
            ->screenshot('h');
        });
    }

    /**
     * A Dusk test show record with table empty.
     *
     * @return void
     */
    public function testListEmpty()
    {
        $this->browse(function (Browser $browser) {
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            DB::table('foods')->truncate();
            $browser->loginAs(User::find(1))
                ->visit('/foods')
                ->assertSee('List Food')
                ->screenshot('hh');
            $elements = $browser->elements('#list-foods-table tbody tr');
            $this->assertCount(0, $elements);
            $this->assertNull($browser->element('.paginate'));
        });
    }

    /**
     * A Dusk test show record with table has data.
     *
     * @return void
     */
    public function testListHasRecord()
    {
        factory(Food::class, 9)->create();
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                ->visit('/foods')
                ->resize(1920, 2000)
                ->assertSee('List Food');
            $elements = $browser->elements('#list-foods-table tbody tr');
            $this->assertCount(9, $elements);
            $this->assertNull($browser->element('.pagination'));
        });
    }

    /**
    * A Dusk test show record with table has data and ensure pagnate.
    *
    * @return void
    */
    public function testShowRecordPaginate()
    {
        factory(Food::class, 21)->create();
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                ->visit('/foods')
                ->resize(1920, 2000)
                ->assertSee('List Food')
                ->screenshot('hhhh');
            $elements = $browser->elements('#list-foods-table tbody tr');
            $this->assertCount(10, $elements);
            $this->assertNotNull($browser->element('.pagination'));
        });
    }

    /**
     * Test click page 2 in pagination link list food
     *
     * @return void
     */
    public function testPathPagination()
    {
        factory(Food::class, 12)->create();
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                    ->visit('/foods?page=2')
                    ->resize(1920, 2000);
            $elements = $browser->elements('#list-foods-table tbody tr');
            $browser->assertPathIs('/foods');
            $browser->assertQueryStringHas('page', 2);
        });
    }
}
