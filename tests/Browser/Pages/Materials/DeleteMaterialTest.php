<?php

namespace Tests\Browser\Pages\Materials;

use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Support\Facades\DB;
use App\Material;
use App\Category;
use App\Supplier;
use Faker\Factory as Faker;

class DeleteMaterialTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * A Dusk test show content.
     *
     * @return void
     */
    public function testContent()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                ->resize(1920, 1080)
                ->visit('/materials')
                ->assertSee("List Materials");
        });
    }

    /**
     * A Dusk test delete material success.
     *
     * @return void
     */
    public function testDeleteSuccess()
    {
        $this->browse(function (Browser $browser) {
            $this->makeData(5);
            $browser->loginAs(User::find(1))
                ->resize(1920, 1080)
                ->visit('/materials')
                ->click('.table tbody tr:nth-child(2) td:nth-child(6) .fa-trash')
                ->waitFor(null, '1')
                ->waitForText('Delete Material')
                ->assertSee('Are you sure delete Material?')
                ->click('#btn-modal-submit')
                ->assertSee('Delete Material Success');
            $this->assertSoftDeleted('materials', ['id' => '2']);
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
            $this->makeData(5);
            $browser->loginAs(User::find(1))
                ->resize(1920, 1080)
                ->visit('/materials');
            DB::table('materials')->delete(2);
            $browser->click('.table tbody tr:nth-child(2) td:nth-child(6) .fa-trash')
                ->waitFor(null, '1')
                ->assertSee('Delete Material')
                ->assertSee('Are you sure delete Material?')
                ->click('#btn-modal-submit')
                ->assertSee('Material Not Found');
        });
    }

    /**
     * A Dusk test Button Cancel.
     *
     * @return void
     */
    public function testButtonCancel()
    {
        $this->browse(function (Browser $browser) {
            $this->makeData(5);
            $browser->loginAs(User::find(1))
                ->resize(1920, 1080)
                ->visit('/materials');
            DB::table('materials')->delete(2);
            $browser->click('.table tbody tr:nth-child(2) td:nth-child(6) .fa-trash')
                ->waitFor(null, '1')
                ->assertSee('Delete Material')
                ->assertSee('Are you sure delete Material?')
                ->click('#modal-confirm-footer .btn-danger')
                ->assertPathIs('/materials');
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
