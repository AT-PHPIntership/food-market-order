<?php

namespace Tests\Browser\Pages\Materials;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Support\Facades\DB;
use App\User;
use App\Category;
use App\Supplier;

class CreateMaterialTest extends DuskTestCase
{
    use DatabaseMigrations;
     
    /**
     * Test link Create Material.
     *
     * @return void
     */
    public function testCreateMaterial()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                    ->visit('/materials')
                    ->click('.fa-plus-circle')
                    ->assertPathIs('/materials/create')
                    ->assertSee('Create Material');
        });
    }

    /**
     * Test Validation Create Material.
     *
     * @return void
     */
    public function testValidationCreateMaterial()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                    ->visit('materials/create')
                    ->press('Create')
                    ->assertPathIs('/materials/create')
                    ->assertSee('The name field is required.')
                    ->assertSee('The category id field is required.')
                    ->assertSee('The supplier id field is required.')
                    ->assertSee('The price field is required.')
                    ->assertSee('The description field is required.');
        });
    }

    /**
     * Test Admin Create Material success.
     *
     * @return void
     */
    public function testCreateMaterialSuccess()
    {
        $this->browse(function (Browser $browser) {
            factory(Category::class, 10)->create();
            factory(Supplier::class, 10)->create();
            $browser->loginAs(User::find(1))
                    ->visit('/materials/create')
                    ->type('name', 'hanh tay')
                    ->select('category_id')
                    ->select('supplier_id')
                    ->type('description', 'hanh tay thom ngon')
                    ->type('price', '100')
                    ->press('Create')
                    ->waitForText('Created Material Success');
        });
        $this->assertDatabaseHas('materials', ['name' => 'hanh tay']);
    }

    public function initDataForTest()
    {
        return [
            ['', '1', '1', 'Rau cai dac san Mien Trung', '10', '1', 'The name field is required.' ],
            ['Rau', '1', '1', 'Rau cai dac san Mien Trung', '10', '1', 'The name must be at least 6 characters.' ],
            ['Rau cai ngot', '', '1', 'Rau cai dac san Mien Trung', '10', '1', 'The category id field is required.' ],
            ['Rau cai ngot', '1', '', 'Rau cai dac san Mien Trung', '10', '1', 'The supplier id field is required.' ],
            ['Rau cai ngot', '1', '1', '', '10', '1', 'The description field is required.' ],
            ['Rau cai ngot', '1', '1', 'Rau cai dac san Mien Trung', '', '1', 'The price field is required.' ],
            ['Rau cai ngot', '1', '1','Rau cai dac san Mien Trung', 'a', '1','The price must be a number.' ],
            ['Rau cai ngot', '1', '1','Rau', '10', '1', 'The description must be at least 10 characters.' ],
            ['hanh tay', '1','1' , 'hanh tay thom ngon', '10', '1', 'The name has already been taken.' ]
        ];
    }

    /**
     * @dataProvider initDataForTest
     *
     */
    public function testCreateMaterialFailValidation(
        $name,
        $category_id,
        $supplier_id,
        $description,
        $price,
        $status,
        $message
    ) {
        factory(Category::class, 10)->create();
        factory(Supplier::class, 10)->create();
        DB::table('materials')->insert([
            'name' => 'hanh tay',
            'category_id' => 1,
            'supplier_id' => 1,
            'description' => 'hanh tay thom ngon',
            'price' => 10,
            'status' => 1,
        ]);
        $this->browse(function (Browser $browser) use (
            $name,
            $category_id,
            $supplier_id,
            $description,
            $price,
            $status,
            $message
        ) {
            $browser->visit('/materials/create')
                ->type('name', $name)
                ->select('category_id', $category_id)
                ->select('supplier_id', $supplier_id)
                ->type('description', $description)
                ->type('price', $price)
                ->select('status', $status)
                ->press('Create')
                ->assertSee($message)
                ->assertPathIs('/materials/create');
        });
    }

    /**
     * Test Reset Button
     *
     */
    public function testButtonReset()
    {
        $this->browse(function (Browser $browser) {
            factory(Category::class, 10)->create();
            factory(Supplier::class, 10)->create();
            $browser->loginAs(User::find(1))
                    ->visit('/materials/create')
                    ->resize(1920, 2000)
                    ->type('name', 'hanh tay')
                    ->select('category_id', '1')
                    ->type('description', 'hanh tay thom ngon')
                    ->type('price', '10')
                    ->click('input[type="reset"]')
                    ->assertPathIs('/materials/create')
                    ->assertInputValueIsNot('name', 'hanh tay')
                    ->assertNotSelected('category_id', '1')
                    ->assertInputValueIsNot('price', '10');
        });
    }
}
