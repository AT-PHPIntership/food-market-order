<?php

namespace Tests\Browser;

use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Support\Facades\DB;
use App\Food;
use App\Category;

class DeleteFoodTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * A Dusk test show content.
     *
     * @return void
     */
    public function testContent()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                ->resize(1920, 1080)
                ->visit('/foods')
                ->assertSee("List Food");
        });
    }

    /**
     * A Dusk test delete food success.
     *
     * @return void
     */
    public function testDeleteSuccess()
    {
        $this->browse(function (Browser $browser) {
            factory(Category::class, 20)->create();
            factory(Food::class, 5)->create();
            $browser->loginAs(User::find(1))
                ->resize(1920, 1080)
                ->visit('/foods')
                ->click('.table tbody tr:nth-child(2) td:nth-child(5) .fa-trash')
                ->waitForText('Delete Food')
                ->assertSee('Are you sure delete food?')
                ->click('#btn-modal-submit')
                ->assertSee('Delete Food Success');
            $this->assertSoftDeleted('foods', ['id' => '2']);
        });
    }

    /**
     * A Dusk test delete fail.
     *
     * @return void
     */
    public function testDeleteFail()
    {
        $this->browse(function (Browser $browser) {
            factory(Category::class, 20)->create();
            factory(Food::class, 5)->create();
            $browser->loginAs(User::find(1))
                ->resize(1920, 1080)
                ->visit('/foods');
            DB::table('foods')->delete(2);
            $browser->click('.table tbody tr:nth-child(2) td:nth-child(5) .fa-trash')
                ->waitForText('Delete Food')
                ->assertSee('Are you sure delete food?')
                ->click('#btn-modal-submit')
                ->assertSee('Food Not Found');
        });
    }
}
