<?php

namespace Tests\Browser;

use App\Category;
use App\Food;
use App\DailyMenu;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\DB;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;

class AdminDeleteMenuTest extends DuskTestCase
{
    use DatabaseTransactions;

    /**
     * @group dailymenu
     *
     * A Dusk test show content.
     *
     * @return void
     */
    public function testContent()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(1)
                ->visit('/daily-menus')
                ->assertSee("LIST DAILY MENUS");
        });
    }

    /**
     * @group dailymenu
     *
     * A Dusk test delete success.
     *
     * @return void
     */
    public function testDeleteSuccess()
    {
        $this->browse(function (Browser $browser) {
            factory(Category::class, 1)->create()->each(function($c) {
                $c->foods()->save(factory(Food::class)->make());
            });
            factory(DailyMenu::class, 1)->create(['food_id' => 1]);
            $element = '.dataTable tbody tr:nth-child(1)';
            $browser->loginAs(1)
                ->resize(1920, 1080)
                ->visit('/daily-menus')
                ->click($element. ' .fa-trash')
                ->waitFor(null, '1')
                ->assertSee('Delete Daily Menu')
                ->assertSee('Are you want delete it?')
                ->click('#btn-modal-submit')
                ->waitFor(null, '1')
                ->assertSee('Delete this menu success');
        });
    }

    /**
     * @group dailymenu
     *
     * A Dusk test delete fail.
     *
     * @return void
     */
    public function testDeleteFail()
    {
        $this->browse(function (Browser $browser) {
            factory(Category::class, 1)->create()->each(function($c) {
                $c->foods()->save(factory(Food::class)->make());
            });
            factory(DailyMenu::class, 1)->create(['food_id' => 1,'date' => '2017-11-11']);
            factory(DailyMenu::class, 1)->create(['food_id' => 1,'date' => '2017-05-11']);
            $browser->loginAs(1)
                ->visit('/daily-menus');
            DB::table('daily_menus')->delete(1);
            $element = '.dataTable tbody tr:nth-child(1)';
            $browser->screenshot('list')
                ->click($element. ' .fa-trash')
                ->waitFor(null, '1')
                ->assertSee('Delete Daily Menu')
                ->assertSee('Are you want delete it?')
                ->click('#btn-modal-submit')
                ->waitFor(null)
                ->assertSee('Has error during delete this');
        });
    }
}
