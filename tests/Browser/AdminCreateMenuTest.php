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
}
