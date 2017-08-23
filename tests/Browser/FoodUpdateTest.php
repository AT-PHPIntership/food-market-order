<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\DB;
use App\User;
use App\Category;
use App\Food;

class UpdateFoodTest extends DuskTestCase
{
     use DatabaseMigrations;
     
    /**
     * Test link UpdateFood Food.
     *
     * @return void
     */
    public function testUpdateFood()
    {
        $this->browse(function (Browser $browser) {
            factory(Category::class, 20)->create();
            factory(Food::class, 5)->create();
            $browser->loginAs(User::find(1))
                    ->visit('/foods')
                    ->click('.table tbody tr:nth-child(2) td:nth-child(6) .fa-edit')
                    ->assertPathIs('/foods/2/edit')
                    ->assertSee('UPDATE FOOD');
        });
    }

    /**
     * Test Validation Update Food.
     *
     * @return void
     */
    public function testValidationUpdateFood()
    {
        $this->browse(function (Browser $browser) {
            factory(Category::class, 20)->create();
            factory(Food::class, 5)->create();
            $browser->loginAs(User::find(1))
                    ->visit('/foods/2/edit')
                    ->type('name', '')
                    ->type('price', '')
                    ->type('description', '')
                    ->press('Save Changes')
                    ->assertPathIs('/foods/2/edit')
                    ->assertSee('The name field is required.')
                    ->assertSee('The price field is required.')
                    ->assertSee('The description field is required.');
        });
    }

    /**
     * Test Admin Update Food success.
     *
     * @return void
     */
    public function testUpdateFoodSuccess()
    {
        $this->browse(function (Browser $browser) {
            factory(Category::class, 20)->create();
            factory(Food::class, 5)->create();
            $browser->loginAs(User::find(1))
                    ->visit('/foods/2/edit')
                    ->type('name', 'mi quang')
                    ->select('category_id')
                    ->type('description', 'mi quang ngon nhat viet nam')
                    ->type('price', '10')
                    ->press('Save Changes')
                    ->assertPathIs('/foods')
                    ->assertSee('Update Food Success');
        });
        $this->assertDatabaseHas('foods', ['name' => 'mi quang']);
    }

    public function initDataForTest()
    {
        return [
            ['', '1', 'mon an ngon nhat', '10', 'The name field is required.' ],
            ['mi', '1', 'mon an ngon nhat', '10', 'The name must be at least 6 characters.' ],
            ['mi quang', '1', '', '10', 'The description field is required.' ],
            ['mi quang', '1', 'mi quang ngon nhat', '', 'The price field is required.' ],
            ['mi quang', '1', 'mi quang ngon nhat', 'a', 'The price must be a number.' ],
            ['mi quang', '1', 'mi', '10', 'The description must be at least 10 characters.' ]
        ];
    }

    /**
     * @dataProvider initDataForTest
     *
     */
    public function testUpdateFoodFailValidation(
        $name,
        $category_id,
        $description,
        $price,
        $message
    ) {
        factory(Category::class, 20)->create();
        DB::table('foods')->insert([
            'name' => 'pho bo hue',
            'category_id' => 1,
            'description' => 'pho bo ngon nhat',
            'price' => 10,
        ]);
        factory(Food::class, 5)->create();
        $this->browse(function (Browser $browser) use (
            $name,
            $category_id,
            $description,
            $price,
            $message
        ) {
            $browser->loginAs(User::find(1))
                ->visit('/foods/2/edit')
                ->type('name', $name)
                ->select('category_id', $category_id)
                ->type('description', $description)
                ->type('price', $price)
                ->press('Save Changes')
                ->assertSee($message)
                ->assertPathIs('/foods/2/edit');
        });
    }

    /**
     * Test Reset Button
     *
     */
    public function testButtonReset()
    {
        $this->browse(function (Browser $browser) {
            factory(Category::class, 20)->create();
            factory(Food::class, 5)->create();
            $food = Food::find(2);
            $browser->loginAs(User::find(1))
                    ->visit('/foods/2/edit')
                    ->resize(1920, 2000)
                    ->type('name', 'mi quang')
                    ->type('description', 'mi quang ngon nhat viet nam')
                    ->type('price', '10')
                    ->click('input[type="reset"]')
                    ->assertPathIs('/foods/2/edit')
                    ->assertInputValue('name', $food->name)
                    ->assertInputValue('description', $food->description)
                    ->assertInputValue('price', $food->price);
        });
    }
}
