<?php

namespace Tests\Browser;

use App\Category;
use Illuminate\Support\Facades\DB;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class UpdateCategoryTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * Test Route View Admin Update Category.
     *
     * @return void
     */
    public function testURL()
    {
        $this->browse(function (Browser $browser) {
            factory(Category::class, 5)->create();
            $category = Category::find(2);
            $browser->loginAs(1)
                ->visit('/categories/'.$category->id.'/edit')
                ->assertSee('UPDATE CATEGORY PAGE')
                ->assertInputValue('name', $category->name)
                ->assertInputValue('description', $category->description);
        });
    }

    /**
     * Test Validation Admin Update Category.
     *
     * @return void
     */
    public function testValidationUpdateCategory()
    {
        $this->browse(function (Browser $browser) {
            factory(Category::class, 5)->create();
            $browser->loginAs(1)
                ->visit('/categories/2/edit')
                ->type('name', '')
                ->press('Update')
                ->waitFor(null,2)
                ->assertPathIs('/categories/2/edit')
                ->assertSee('The name field is required.');
        });
    }

    /**
     * Test Admin update Category success.
     *
     * @return void
     */
    public function testUpdateCategorySuccess()
    {
        $this->browse(function (Browser $browser) {
            factory(Category::class, 5)->create();
            $browser->loginAs(1)
                ->visit('/categories/2/edit')
                ->type('name', 'Hải Sản');
            $browser->press('Update')
                ->assertPathIs('/categories')
                ->assertSee('Update Category Success');
        });
        $this->assertDatabaseHas('categories', ['name' => 'Hải Sản']);
    }


    public function listCaseTestValidationForUpdateCategory()
    {
        return [
            ['', 'test user', 'The name field is required.'],
            ['Category Test', 'test user', 'The name has already been taken.']
        ];
    }

    /**
     * @dataProvider listCaseTestValidationForUpdateCategory
     *
     */
    public function testUpdateCategoryFailValidation(
        $name,
        $description,
        $message
    )
    {
        factory(Category::class, 5)->create();
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
                ->visit('/categories/2/edit')
                ->type('name', $name)
                ->type('description', $description);
            $browser->press('Update')
                ->assertPathIs('/categories/2/edit')
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
            factory(Category::class, 5)->create();
            $category = Category::find(2);
            $browser->loginAs(1)
                ->visit('/categories/2/edit')
                ->type('name', 'category test')
                ->type('description', 'description test');
            $browser->click('input[type=reset]')
                ->assertPathIs('/categories/2/edit')
                ->assertInputValue('name', $category->name)
                ->assertInputValue('description', $category->description);
        });
    }
}
