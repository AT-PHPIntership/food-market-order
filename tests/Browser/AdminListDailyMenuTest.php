<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Facebook\WebDriver\Chrome\ChromeOptions;
use \App\DailyMenu;
use \App\Food;
use \App\Category;


class AdminListDailyMenuTest extends DuskTestCase
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
     * Test data empty.
     *
     * @return void
     */
    public function testDataEmpty()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(1)
                ->visit('/daily-menus')
                ->assertSee('LIST DAILY MENUS ');
            $elements = $browser->elements('.dataTable tbody tr');
            $numRecord = count($elements);
            $this->assertTrue($numRecord == 0);
        });
    }

    /**
     * @group dailymenu
     *
     * A Dusk test count object in list=10.
     *
     * @return void
     */
    public function testHasOnePage()
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
            $objectCount = $browser->elements('.table tbody tr');
            $this->assertTrue(count($objectCount)==10);
        });
    }

    /**
     * @group dailymenu
     *
     * A Dusk test count object in list=11.
     *
     * @return void
     */
    public function testPagination()
    {
        $category = factory(Category::class, 1)->create();
        $foods = factory(Food::class, 11)->create(['category_id' => 1]);
        factory(DailyMenu::class, 11)->create([
            'food_id' => 1
        ]);
        $this->browse(function (Browser $browser) {
            $browser->loginAs(1)
            ->visit('/daily-menus')
            ->resize(1920, 2000);
            //page 1 have 10 record
            $objectCount = $browser->elements('.table tbody tr');
            $this->assertTrue(count($objectCount)==10);
            //page 2 have 1 record
            $objectCount = $browser->visit('daily-menus?page=2')
                ->elements('.table tbody tr');
            $this->assertTrue(count($objectCount)==1);
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
            $element = '.box-tools .fa fa-search';
            $browser->loginAs(1)
                    ->visit('/daily-menus')
                    ->type('search', '2017')
                    ->click('.box-body .box-tools form button')
                    ->assertSee('2017-09-11')
                    ->assertQueryStringHas('search', '2017')
                    ->screenshot('search')
                    ->type('search', '05')
                    ->click('.box-body .box-tools form button')
                    ->assertDontSee('2017-09-11')
                    ->assertQueryStringHas('search', '05')
                    ->screenshot('search2');
        });
    }
}
