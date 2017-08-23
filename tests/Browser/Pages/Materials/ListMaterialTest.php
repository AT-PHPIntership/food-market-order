<?php

namespace Tests\Browser\Pages\Materials;

use App\Category;
use App\Material;
use App\User;
use App\Supplier;
use Tests\TestCase;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Faker\Factory as Faker;

class ListMaterialTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * A Dusk test URL material list.
     *
     * @return void
     */
    public function testURL()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
            ->visit('/materials')
            ->assertPathIs('/materials')
            ->assertPathIsNot('/Materials')
            ->assertSee('List Materials');
        });
    }

    /**
     * A Dusk test show record with empty data.
     *
     * @return void
     */
    public function testListEmpty()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                ->visit('/materials')
                ->assertSee('List Materials');
            $elements = $browser->elements('.table tbody tr');
            $this->assertCount(0, $elements);
            $this->assertNull($browser->element('.pagination'));
        });
    }

    /**
     * A Dusk test show record with table has data.
     *
     * @return void
     */
    public function testListHasRecord()
    {
        $this->makeData(10);
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                ->visit('/materials')
                ->resize(1920, 2000)
                ->assertSee('List Materials');
            $elements = $browser->elements('.table tbody tr');
            $this->assertCount(10, $elements);
            $this->assertNull($browser->element('.pagination'));
        });
    }

    /**
    * A Dusk test show records and paginate.
    *
    * @return void
    */
    public function testShowRecordPaginate()
    {
        $this->makeData(21);
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                ->visit('/materials')
                ->resize(1920, 2000)
                ->assertSee('List Materials');
            $elements = $browser->elements('.table tbody tr');
            $this->assertCount(10, $elements);
            $this->assertNotNull($browser->element('.pagination'));
            $paginateElement = $browser->elements('.pagination li');
            $numberPage = count($paginateElement)- 2;
            $this->assertTrue($numberPage == 3);
        });
    }

    /**
     * Test click link paginate
     *
     * @return void
     */
    public function testPathPagination()
    {
        $this->makeData(12);
        $this->browse(function (Browser $browser) {
            $browser->visit('/materials?page=2');
            $elements = $browser->elements('.table tbody tr');
            $this->assertCount(2, $elements);
            $browser->assertQueryStringHas('page', 2);
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
