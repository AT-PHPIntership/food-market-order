<?php

namespace Tests\Browser\DailyMenu;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Facebook\WebDriver\Chrome\ChromeOptions;
use \App\User;
use \App\DailyMenu;
use \App\Food;
use \App\Category;

class ListTest extends DuskTestCase
{
    use DatabaseTransactions;
    use WithoutMiddleware;

    /**
     * A Dusk test URL admin view list daily menu.
     *
     * @return void
     */
    public function testURL()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(1)
            ->visit('/dashboard')
            ->clickLink('Management')
            ->clickLink('Daily Menu Management')
            ->assertPathIs('/daily-menus');
        });
    }

    /**
     * A Dusk test count object in list=10.
     *
     * @return void
     */
    public function testObject10()
    {
        $category = factory(Category::class, 1)->create();
        $foods = factory(Food::class, 10)->create(['category_id' => 1]);
        $dailyMenus = factory(DailyMenu::class, 10)->create([
            'food_id' => 1
        ]);
        $this->browse(function (Browser $browser) {
            $browser->loginAs(1)
            ->visit('/daily-menus');
            $objectCount = $browser->elements('#listDailyMenu tbody tr');
            $this->assertTrue(count($objectCount)==10);
        });
    }

    /**
     * A Dusk test count object in list=11.
     *
     * @return void
     */
    public function testObject11()
    {
        $category = factory(Category::class, 1)->create();
        $foods = factory(Food::class, 11)->create(['category_id' => 1]);
        $dailyMenus = factory(DailyMenu::class, 11)->create([
            'food_id' => 1
        ]);
        $this->browse(function (Browser $browser) {
            $browser->loginAs(1)
            ->visit('/daily-menus')
            ->resize(1920, 2000);
            $objectCount = $browser->elements('#listDailyMenu tbody tr');
            $this->assertTrue(count($objectCount)==10);
        });
    }

    /**
     * A Dusk test show search
     *
     * @return void
     */
    public function testSearch()
    {
        $category = factory(Category::class, 1)->create();
        $foods = factory(Food::class, 1)->create(['category_id' => 1]);
        $dailyMenus = factory(DailyMenu::class, 1)->create([
            'food_id' => 1,
            'date' => '1991-01-02'
        ]);
        $this->browse(function (Browser $browser) {
            $browser->loginAs(1)
                    ->visit('/daily-menus')
                    ->type('date', '1991')
                    ->assertSee('1991-01-02')
                    ->type('date', '01')
                    ->assertSee('1991-01-02');
        });
    }    

    /**
     * A Dusk test show list daily menu
     *
     * @return void
     */
    public function testShowList()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(1)
                    ->visit('/daily-menus')
                    ->assertSee('Daily Menu List');
        });
    }
}
