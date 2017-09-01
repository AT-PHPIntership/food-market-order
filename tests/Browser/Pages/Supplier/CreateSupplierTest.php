<?php

namespace Tests\Browser;

use Illuminate\Support\Facades\DB;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class CreateSupplierTest extends DuskTestCase
{
    /**
     * Test Route View Admin Create Supplier.
     *
     * @return void
     */
    public function testURL()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(1)
                ->visit('/suppliers/create')
                ->assertSee('CREATE SUPPLIER PAGE');
        });
    }

    /**
     * Test Validation Admin Create Supplier.
     *
     * @return void
     */
    public function testValidationCreatesSupplier()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(1)
                ->visit('/suppliers/create')
                ->press('Create')
                ->assertPathIs('/suppliers/create')
                ->assertSee('The name field is required.');
        });
    }

    /**
     * Test Admin create Supplier success.
     *
     * @return void
     */
    public function testCreatesSupplierSuccess()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(1)
                ->visit('/suppliers/create')
                ->type('name', 'HHTT1')
                ->type('description', 'Nguyên liệu tươi sạch ở các vùng biển');
            $browser->press('Create')
                ->assertPathIs('/suppliers')
                ->assertSee('Create Supplier Success');
        });
        $this->assertDatabaseHas('suppliers', ['name' => 'HHTT1']);
    }


    public function listCaseTestValidationForCreateSupplier()
    {
        return [
            ['', 'test supplier', 'The name field is required.'],
            ['Supplier Test', 'test supplier', 'The name has already been taken.']
        ];
    }

    /**
     * @dataProvider listCaseTestValidationForCreateSupplier
     *
     */
    public function testCreateSupplierFailValidation(
        $name,
        $description,
        $message
    )
    {
        DB::table('suppliers')->insert([
            'name' => 'Supplier Test',
            'description' => ''
        ]);
        $this->browse(function (Browser $browser) use (
            $name,
            $description,
            $message
        ) {

            $browser->loginAs(1)
                ->visit('/suppliers/create')
                ->type('name', $name)
                ->type('description', $description);
            $browser->press('Create')
                ->assertPathIs('/suppliers/create')
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
                ->visit('/suppliers/create')
                ->type('name', 'supplier test')
                ->type('description', 'description test');
            $browser->click('input[type=reset]')
                ->assertPathIs('/suppliers/create')
                ->assertInputValue('name', null)
                ->assertInputValue('description', null);
        });
    }
}