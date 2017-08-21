<?php

namespace Tests\Browser\DailyMenu;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Facebook\WebDriver\Chrome\ChromeOptions;
use \App\DailyMenu;
use \App\Food;
use \App\Category;

class ListTest extends DuskTestCase
{
    use DatabaseTransactions;
    use WithoutMiddleware;

    /**
     * @group dailymenu
     *
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
     * A Dusk test count object in list=10.
     *
     * @return void
     */
    public function testPaginationWith10Rows()
    {
        $category = factory(Category::class, 1)->create();
        $foods = factory(Food::class, 10)->create(['category_id' => 1]);
        $dailyMenus = factory(DailyMenu::class, 10)->create([
            'food_id' => 1
        ]);
        $this->browse(function (Browser $browser) {
            $browser->loginAs(1)
            ->visit('/daily-menus')
            ->resize(1920, 2000);
            $objectCount = $browser->elements('.table tr');
            $this->assertTrue(count($objectCount)==11);
        });
    }

    /**
     * @group dailymenu
     *
     * A Dusk test count object in list=11.
     *
     * @return void
     */
    public function testPaginationMorethan10Rows()
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
            $objectCount = $browser->elements('.table tr');
            $this->assertTrue(count($objectCount)==11);
        });
    }

    /**
     * @group dailymenu
     *
     * A Dusk test show search
     *
     * @return void
     */
    public function testSearch()
    {
        $this->browse(function (Browser $browser) {
            factory(Category::class, 1)->create()->each(function($c) {
                $c->foods()->save(factory(Food::class)->make());
            });
            factory(DailyMenu::class, 1)->create(['food_id' => 1, 'date' => '2017-09-11']);
            factory(DailyMenu::class, 10)->create(['food_id' => 1]);
            $element = 'tbody tr:nth-child(2)';
            $browser->loginAs(1)
                    ->visit('/daily-menus')
                    ->type('search', '2017')
                    ->press('Search')
                    ->assertSee('2017-09-11')
                    ->screenshot('search')
                    ->type('date', '05')
                    ->press('Search')
                    ->assertDontSee('2017-09-11')
                    ->screenshot('search2');
        });
    }    

    /**
     * @group dailymenu
     *
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
