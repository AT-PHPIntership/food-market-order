<?php

namespace Tests\Browser;

use Illuminate\Support\Facades\DB;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class CreateCategoryTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * Test Route View Admin Create Category.
     *
     * @return void
     */
    public function testURL()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(1)
                ->visit('/categories/create')
                ->assertSee('CREATE CATEGORIES PAGE');
        });
    }

    /**
     * Test Validation Admin Create Category.
     *
     * @return void
     */
    public function testValidationCreatesCategory()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(1)
                ->visit('/categories/create')
                ->press('Create')
                ->assertPathIs('/categories/create')
                ->assertSee('The name field is required.');
        });
    }

    /**
     * Test Admin create Category success.
     *
     * @return void
     */
    public function testCreatesCategorySuccess()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(1)
                ->visit('/categories/create')
                ->type('name', 'Hải Sản')
                ->type('description', 'Nguyên liệu tươi sạch ở các vùng biển');
            $browser->press('Create')
                ->assertPathIs('/categories')
                ->assertSee('Create Category Success');
        });
        $this->assertDatabaseHas('categories', ['name' => 'Hải Sản']);
    }


    public function listCaseTestValidationForCreateCategory()
    {
        return [
            ['', 'test category', 'The name field is required.'],
            ['Category Test', 'test category', 'The name has already been taken.']
        ];
    }

    /**
     * @dataProvider listCaseTestValidationForCreateCategory
     *
     */
    public function testCreateCategoryFailValidation(
        $name,
        $description,
        $message
    )
    {
        DB::table('categories')->insert([
            'name' => 'Category Test',
            'description' => ''
        ]);
        $this->browse(function (Browser $browser) use (
            $name,
            $description,
            $message
        ) {

            $browser->loginAs(1)
                ->visit('/categories/create')
                ->type('name', $name)
                ->type('description', $description);
            $browser->press('Create')
                ->assertPathIs('/categories/create')
                ->assertSee($message);
        });
    }

    /**
     * Test Button Reset
     *
     */
    public function testBtnReset()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(1)
                ->visit('/categories/create')
                ->type('name', 'category test')
                ->type('description', 'description test');
            $browser->click('input[type=reset]')
                ->assertPathIs('/categories/create')
                ->assertInputValue('name', null)
                ->assertInputValue('description', null);
        });
    }
}
