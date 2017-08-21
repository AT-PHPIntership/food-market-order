<?php

namespace Tests\Browser;

use App\Category;
use App\Food;
use App\DailyMenu;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\DB;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;

class AdminUpdateMenuTest extends DuskTestCase
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
    public function testUpdateSuccess()
    {
        $this->browse(function (Browser $browser) {
            factory(Category::class, 1)->create()->each(function($c) {
                $c->foods()->save(factory(Food::class)->make());
            });
            factory(DailyMenu::class, 1)->create(['food_id' => 1, 'date' => '2017-09-11']);
            $elementMenu = '.dataTable tbody tr:nth-child(1)';
            $browser->loginAs(1)
                ->resize(1920, 1080)
                ->visit('/daily-menus')
                ->click($elementMenu. ' .fa-search-plus')
                ->waitFor(null, '5')
                ->assertSee('Daily Menu For');
            $elementMenuItem = '.table tr:nth-child(2)';
            $browser->type($elementMenuItem. ' .quantity', 3)
                    ->click($elementMenuItem. ' .glyphicon-ok')
                    ->waitFor(null, '1000')
                    ->waitForText('Update menu item success')
                    ->click('.btn-danger')
                    ->assertSee('Daily Menu For')
                    ->screenshot('update menu');
        });
        $this->assertDatabaseHas('daily_menus', ['date' => '2017-09-11', 'food_id' => 1, 'quantity' => 3]);
    }

    /**
     * @group dailymenu
     *
     * Test Validation Update Menu Item.
     *
     * @return void
     */
    public function testValidationUpdateMenuItem()
    {
        $this->browse(function (Browser $browser) {
            factory(Category::class, 1)->create()->each(function($c) {
                $c->foods()->save(factory(Food::class)->make());
            });
            factory(DailyMenu::class, 1)->create(['food_id' => 1, 'date' => '2017-09-11']);
            $elementMenu = '.dataTable tbody tr:nth-child(1)';
            $browser->loginAs(1)
                    ->resize(1920, 1080)
                    ->visit('/daily-menus')
                    ->click($elementMenu. ' .fa-search-plus')
                    ->waitFor(null, '5')
                    ->assertSee('Daily Menu For');
            $elementMenuItem = '.table tr:nth-child(2)';
            $browser->type($elementMenuItem. ' .quantity', 0)
                    ->click($elementMenuItem. ' .glyphicon-ok')
                    ->waitFor(null)
                    ->assertSee('The quantity must be at least 1.')
                    ->clear($elementMenuItem. ' .quantity')
                    ->click($elementMenuItem. ' .glyphicon-ok')
                    ->waitFor(null)
                    ->assertSee('The quantity field is required.');
        });
    }
}
