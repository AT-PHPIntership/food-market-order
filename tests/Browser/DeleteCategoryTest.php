<?php

namespace Tests\Browser;

use App\Category;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\DB;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;

class DeleteCategoryTest extends DuskTestCase
{
    use DatabaseTransactions;

    /**
     * A Dusk test show content.
     *
     * @return void
     */
    public function testContent()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(1)
                ->visit('/categories')
                ->assertSee("LIST CATEGORIES PAGE");
        });
    }

    /**
     * A Dusk test delete success.
     *
     * @return void
     */
    public function testDeleteSuccess()
    {
        $this->browse(function (Browser $browser) {
            factory(Category::class, 5)->create();
            $element = '.dataTable tbody tr:nth-child(2)';
            $browser->loginAs(1)
                ->visit('/categories')
                ->resize(1920, 1080)
                ->click($element. ' .btn-danger')
                ->waitFor(null, '5')
                ->assertSee('Delete Category')
                ->assertSee('Are you want delete it?')
                ->click('#btn-modal-submit')
                ->assertSee('Delete Category Success');
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
            factory(Category::class, 5)->create();
            $browser->loginAs(1)
                ->resize(1920, 1080)
                ->visit('/categories');
            DB::table('categories')->delete(2);
            $element = '.dataTable tbody tr:nth-child(2)';
            $browser->click($element. ' .btn-danger')
                ->waitFor(null, '3')
                ->assertSee('Delete Category')
                ->assertSee('Are you want delete it?')
                ->click('#btn-modal-submit')
                ->assertSee('Category Not Found!');
        });
    }
}
