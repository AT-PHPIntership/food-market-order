<?php

namespace Tests\Browser;

use App\Category;
use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Support\Facades\DB;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ListCategoryTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testURL()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                ->visit('/categories')
                ->assertSee('List Categories');
        });
    }

    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testClickAdd()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/categories')
                ->click('#btn-add-category')
                ->assertPathIs('/categories/create');
        });
    }

    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testClickDelete()
    {
        $this->browse(function (Browser $browser) {
            // Click button add category
            $element = 'tbody tr:nth-child(2)';
            $id = $browser->visit('/categories')
                ->text($element. ' td');
            echo $id;
            $browser->visit('/categories')
                ->click($element. ' .fa-trash')
                ->assertSee('Delete Category')
                ->screenshot('s')
                ->assertPathIs('/categories');
        });
    }
}
