<?php

namespace Tests\Browser\Pages\Materials;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\DB;
use App\User;
use App\Category;
use App\Material;
use App\Supplier;
use Faker\Factory as Faker;

class UpdateMaterialTest extends DuskTestCase
{
    use DatabaseMigrations;
     
    /**
     * Test link UpdateMaterial.
     *
     * @return void
     */
    public function testUpdateMaterial()
    {
        $this->browse(function (Browser $browser) {
            $this->makeData(5);
            $browser->loginAs(User::find(1))
                    ->visit('/materials')
                    ->click('.table tbody tr:nth-child(2) td:nth-child(7) .fa-edit')
                    ->assertPathIs('/materials/2/edit')
                    ->assertSee('UPDATE MATERIAL');
        });
    }

    /**
     * Test Validation Update Material.
     *
     * @return void
     */
    public function testValidationUpdateMaterial()
    {
        $this->browse(function (Browser $browser) {
            $this->makeData(5);
            $browser->loginAs(User::find(1))
                    ->visit('/materials/2/edit')
                    ->type('name', '')
                    ->type('price', '')
                    ->type('description', '')
                    ->press('Save Changes')
                    ->assertPathIs('/materials/2/edit')
                    ->assertSee('The name field is required.')
                    ->assertSee('The price field is required.')
                    ->assertSee('The description field is required.');
        });
    }

    /**
     * Test Admin Update Material success.
     *
     * @return void
     */
    public function testUpdateMaterialSuccess()
    {
        $this->browse(function (Browser $browser) {
            $this->makeData(5);
            $browser->loginAs(User::find(1))
                    ->visit('/materials/2/edit')
                    ->type('name', 'hanh tay')
                    ->select('category_id')
                    ->select('supplier_id')
                    ->type('description', 'hanh tay thom ngon')
                    ->type('price', '10')
                    ->select('status', '1')
                    ->press('Save Changes')
                    ->assertPathIs('/materials')
                    ->assertSee('Update Material Success');
        });
        $this->assertDatabaseHas('materials', ['name' => 'hanh tay']);
    }

    public function initDataForTest()
    {
        return [
            ['', '1', '1', 'Rau cai dac san Mien Trung', '10', '1', 'The name field is required.' ],
            ['Rau', '1', '1', 'Rau cai dac san Mien Trung', '10', '1', 'The name must be at least 6 characters.' ],
            ['Rau cai ngot', '1', '1', '', '10', '1', 'The description field is required.' ],
            ['Rau cai ngot', '1', '1', 'Rau cai dac san Mien Trung', '', '1', 'The price field is required.' ],
            ['Rau cai ngot', '1', '1','Rau cai dac san Mien Trung', 'a', '1','The price must be a number.' ],
            ['Rau cai ngot', '1', '1','Rau', '10', '1', 'The description must be at least 10 characters.' ],
            ['hanh tay', '1', '1','Rau cu Da Nang', '10', '1', 'The name has already been taken.' ],
        ];
    }

    /**
     * @dataProvider initDataForTest
     *
     */
    public function testUpdateMaterialFailValidation(
        $name,
        $category_id,
        $supplier_id,
        $description,
        $price,
        $status,
        $message
    ) {
        $this->makeData(5);
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
            $browser->loginAs(User::find(1))
                ->visit('/materials/2/edit')
                ->type('name', $name)
                ->select('category_id', $category_id)
                ->select('supplier_id', $supplier_id)
                ->type('description', $description)
                ->type('price', $price)
                ->select('status', $status)
                ->press('Save Changes')
                ->assertSee($message)
                ->assertPathIs('/materials/2/edit');
        });
    }

    /**
     * Test Reset Button
     *
     */
    public function testButtonReset()
    {
        $this->browse(function (Browser $browser) {
            $this->makeData(5);
            $material = Material::find(2);
            $browser->loginAs(User::find(1))
                    ->visit('/materials/2/edit')
                    ->resize(1920, 2000)
                    ->type('name', 'hanh tay')
                    ->type('description', 'hanh tay thom ngon')
                    ->type('price', '10')
                    ->click('input[type="reset"]')
                    ->assertPathIs('/materials/2/edit')
                    ->assertInputValue('name', $material->name)
                    ->assertInputValue('description', $material->description)
                    ->assertInputValue('price', $material->price);
        });
    }

    /**
     * Make data for test.
     *
     * @return void
     */
    public function makeData($row)
    {
        factory(Supplier::class, 10)->create();
        factory(Category::class, 10)->create();
        $supplierIds = Supplier::all('id')->pluck('id')->toArray();
        $categoryIds = Category::all('id')->pluck('id')->toArray();
        $faker = Faker::create();
        for ($i = 0; $i < $row; $i++) {
            factory(Material::class, 1)->create([
                'category_id' => $faker->randomElement($categoryIds),
                'supplier_id' => $faker->randomElement($supplierIds),
            ]);
        }
    }
}
