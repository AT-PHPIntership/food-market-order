<?php

namespace Tests\Browser;

use App\Supplier;
use Illuminate\Support\Facades\DB;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class DeleteSupplierTest extends DuskTestCase
{
    /**
     * A Dusk test show content.
     *
     * @return void
     */
    public function testContent()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(1)
                ->visit('/suppliers')
                ->assertSee("LIST SUPPLIERS");
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
            factory(Supplier::class, 5)->create();
            $element = '.dataTable tbody tr:nth-child(2)';
            $browser->loginAs(1)
                ->visit('/suppliers')
                ->click($element. ' .fa-trash')
                ->waitFor('#modal-confirm', '3');
            $browser->assertSee('Delete Supplier')
                ->assertSee('Are you want delete it?')
                ->click('#btn-modal-submit')
                ->assertSee('Delete Supplier Success');
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
            factory(Supplier::class, 5)->create();
            $browser->loginAs(1)
                ->visit('/suppliers');
            DB::table('suppliers')->delete(2);
            $element = '.dataTable tbody tr:nth-child(2)';
            $browser->click($element. ' .fa-trash')
                ->waitFor(null, '3')
                ->assertSee('Delete Supplier')
                ->assertSee('Are you want delete it?')
                ->click('#btn-modal-submit')
                ->assertSee('Supplier Not Found!');
        });
    }
}
