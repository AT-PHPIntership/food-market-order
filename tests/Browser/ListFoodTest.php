<?php

namespace Tests\Browser;

use Tests\BrowserKitTest;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Food;
use App\User;

class ListFoodTest extends DuskTestCase
{
    use WithoutMiddleware;
    use DatabaseTransactions;

    // public function testStatusCode()
    // {
    //     $this->browse(function (Browser $browser) {
    //         $browser->loginAs(User::find(1))
    //                 ->visit('/foods')
    //                 ->screenshot('1')
    //                 ->assertResponseStatus(200);
    //     });
    // }

    /**
     * Test view list Food
     *
     * @return void
     */
    public function testURL()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                    ->visit('/foods')
                    ->screenshot('2')
                    ->assertSee('List Food');
        });
    }

    // public function testHasZeroListFoods()
    // {
    //     DB::table('foods')->truncate();
    // }
}
