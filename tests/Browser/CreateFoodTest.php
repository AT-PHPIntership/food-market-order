<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\DB;
use App\User;
use App\Food;

class CreateFoodTest extends DuskTestCase
{
     use DatabaseMigrations;
     
    /**
     * Test link Create Food.
     *
     * @return void
     */
    public function testCreatesFood()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                    ->visit('/foods')
                    ->click('.fa-plus')
                    ->assertPathIs('/foods/create')
                    ->assertSee('Create Food');
        });
    }

    /**
     * Test Validation Create Food.
     *
     * @return void
     */
    public function testValidationCreatesFood()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                    ->visit('foods/create')
                    ->press('Create')
                    ->assertPathIs('/foods/create')
                    ->assertSee('The name field is required.')
                    ->assertSee('The category id field is required.')
                    ->assertSee('The price field is required.')
                    ->assertSee('The description field is required.');
        });
    }

    /**
     * Test Admin create Food success.
     *
     * @return void
     */
    public function testCreateFoodSuccess()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                    ->visit('/foods/create')
                    ->type('name', 'mi quang')
                    ->select('category_id')
                    ->type('description', 'mi quang ngon nhat viet nam')
                    ->type('price', '10')
                    ->press('Create')
                    ->assertPathIs('/foods')
                    ->assertSee('Food Created');
        });
        $this->assertDatabaseHas('foods', ['name' => 'mi quang']);
    }

    public function initDataForTest()
    {
        return [
            ['', '1', 'mon an ngon nhat', '10', 'The name field is required.' ],
            ['mi', '1', 'mon an ngon nhat', '10', 'The name must be at least 6 characters.' ],
            ['mi quang', '', 'mi quang ngon nhat', '10', 'The category id field is required.' ],
            ['mi quang', '1', '', '10', 'The description field is required.' ],
            ['mi quang', '1', 'mi quang ngon nhat', '', 'The price field is required.' ],
            ['mi quang', '1', 'mi quang ngon nhat', 'a', 'The price must be a number.' ],
            ['mi quang', '1', 'mi', '10', 'The description must be at least 10 characters.' ],
            ['pho bo hue', '1', 'pho bo ngon nhat Viet Nam', '10', 'The name has already been taken.' ]
        ];
    }

    /**
     * @dataProvider initDataForTest
     *
     */
    public function testCreateFoodFailValidation(
        $name,
        $category_id,
        $description,
        $price,
        $message
    ) {
        DB::table('foods')->insert([
            'name' => 'pho bo hue',
            'category_id' => 1,
            'description' => 'pho bo ngon nhat',
            'price' => 10,
        ]);
        $this->browse(function (Browser $browser) use (
            $name,
            $category_id,
            $description,
            $price,
            $message
        ) {
            $browser->visit('/foods/create')
                ->type('name', $name)
                ->select('category_id', $category_id)
                ->type('description', $description)
                ->type('price', $price)
                ->press('Create')
                ->assertSee($message)
                ->assertPathIs('/foods/create');
        });
    }

    /**
     * Test Reset Button
     *
     */
    public function testButtonReset()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                    ->visit('/foods/create')
                    ->resize(1920, 2000)
                    ->type('name', 'mi quang')
                    ->select('category_id', '1')
                    ->type('description', 'mi quang ngon nhat viet nam')
                    ->type('price', '10')
                    ->click('input[type="reset"]')
                    ->assertPathIs('/foods/create')
                    ->assertInputValueIsNot('name', 'mi quang')
                    ->assertNotSelected('category_id', '1')
                    ->assertInputValueIsNot('price', '10');
        });
    }
}
