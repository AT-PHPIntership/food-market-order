<?php

namespace Tests\Browser;

use App\Category;
use App\Food;
use App\DailyMenu;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\DB;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;

class AdminCreateMenuTest extends DuskTestCase
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
                ->visit('/daily-menus/create')
                ->assertSee("Create New Menu Item");
        });
    }

    /**
     * @group dailymenu
     *
     * A Dusk test create success.
     *
     * @return void
     */
    public function testCreateSuccess()
    {
        $this->browse(function (Browser $browser) {
            factory(Category::class, 1)->create()->each(function($c) {
                $c->foods()->save(factory(Food::class)->make());
            });
            $browser->loginAs(1)
                    ->visit('/daily-menus/create')
                    ->script([
                        "curDate = new Date();",
                        "curDate.setDate(curDate.getDate() + 1);",
                        "document.querySelector('#chooser-date').value = curDate.toJSON().slice(0,10)"
                    ]);
            $elementSelect = 'tbody tr td:nth-child(2) span:nth-child(1)';
            $browser->select('category_id')
                    ->waitFor(null, '1')
                    ->click($elementSelect)
                    ->waitFor(null, '1')
                    ->screenshot('AdminCreateMenu-CategorySelected');
            $option = '#select2-select-food-results li:nth-child(1)';
            $browser->click($option)
                    ->waitFor(null, '1')
                    ->screenshot('AdminCreateMenu-FoodSelected')
                    ->type('quantity', 5)
                    ->press('Add To Menu')
                    ->waitFor(null, '1')
                    ->assertSee('Menu was successfully added!')
                    ->screenshot('AdminCreateMenu-Success');
        });
        $this->assertDatabaseHas('daily_menus', ['date' => date('Y-m-d', strtotime(' +1 day')), 'food_id' => 1, 'quantity' => 5]);
    }

    /**
     * @group dailymenu
     *
     * Test Validation Create Menu.
     *
     * @return void
     */
    public function testValidationCreateMenu()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(1)
                    ->visit('/daily-menus/create')
                    ->press('Add To Menu')
                    ->waitFor(null, '1')
                    ->assertSee('The date field is required.')
                    ->assertSee('The food id must be an integer.')
                    ->assertSee('The quantity field is required.')
                    ->screenshot('AdminCreateMenu-Validation');
        });
    }

    /**
     * @group dailymenu
     *
     * Test input date invalid.
     *
     * @return void
     */
    public function testInvalidDateInput()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(1)
                    ->visit('/daily-menus/create')
                    ->click('#chooser-date')
                    ->keys('#chooser-date', ['{ARROW_UP}', ''])
                    ->click('#add-row')
                    ->assertSee('Please enter a valid value.');
        });
    }

    /**
     * @group dailymenu
     *
     * Test input date < current date.
     *
     * @return void
     */
    public function testInputDateLowerThanCurrentDate()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(1)
                    ->visit('/daily-menus/create')
                    ->resize(1920, 1080)
                    ->click('#chooser-date')
                    ->keys('#chooser-date', ['{ARROW_UP}', ''])
                    ->keys('#chooser-date', ['{TAB}', ''])
                    ->keys('#chooser-date', ['{ARROW_UP}', ''])
                    ->keys('#chooser-date', ['{TAB}', ''])
                    ->keys('#chooser-date', ['{ARROW_UP}', ''])
                    ->keys('#chooser-date', ['{TAB}', '']);
            $browser->waitFor(null, '1')
                    ->assertSourceHas('id="add-row" class="btn btn-primary" value="Add To Menu" disabled=""');
        });
    }

    /**
     * @group dailymenu
     */
    public function listCaseTestValidationForCreateMenu()
    {
        return [
            ['', 1, 1, 'The date field is required.'],
            [date('Y-m-d', strtotime(' +1 day')), '', 1, 'The food id must be an integer.'],
            [date('Y-m-d', strtotime(' +1 day')), 1, '', 'The quantity field is required.']
        ];
    }

    /**
     * @group dailymenu
     *
     * @dataProvider listCaseTestValidationForCreateMenu
     *
     */
    public function testCreateMenuFailValidation(
        $date,
        $food_id,
        $quantity,
        $message
    )
    {
        factory(Category::class, 1)->create()->each(function($c) {
            $c->foods()->save(factory(Food::class)->make());
        });
        $this->browse(function (Browser $browser) use (
            $date,
            $food_id,
            $quantity,
            $message
        ) {

            $browser->loginAs(1)
                ->visit('/daily-menus/create')
                ->value('#chooser-date', $date);
            $browser->select('food_id', $food_id)
                    ->waitFor(null, '1')
                    ->type('quantity', $quantity)
                    ->press('Add To Menu')
                    ->assertPathIs('/daily-menus/create')
                    ->assertSee($message);
        });
    }

    /**
     * @group dailymenu
     *
     * Test Button Cancel
     *
     */
    public function testBtnCancel()
    {
        $this->browse(function (Browser $browser) {
            factory(Category::class, 1)->create()->each(function($c) {
                $c->foods()->save(factory(Food::class)->make());
            });
            $browser->loginAs(1)
                    ->visit('/daily-menus/create')
                    ->script([
                        "curDate = new Date();",
                        "curDate.setDate(curDate.getDate() + 1);",
                        "document.querySelector('#chooser-date').value = curDate.toJSON().slice(0,10)"
                    ]);
            $elementSelect = 'tbody tr td:nth-child(2) span:nth-child(1)';
            $browser->select('category_id')
                    ->waitFor(null, '1')
                    ->click($elementSelect)
                    ->waitFor(null, '1')
                    ->screenshot('AdminCreateMenu-CategorySelected');
            $option = '#select2-select-food-results li:nth-child(1)';
            $browser->click($option)
                    ->waitFor(null, '1')
                    ->screenshot('AdminCreateMenu-FoodSelected')
                    ->type('quantity', 5)
                    ->click('#clear-input')
                    ->assertInputValue('date', null)
                    ->assertSelected('#select-food', null)
                    ->assertInputValue('quantity', null);
        });
    }
}
