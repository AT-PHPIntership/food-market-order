<?php
/**
 * Created by PhpStorm.
 * User: dungvand
 * Date: 21/09/17
 * Time: 15:28
 */

namespace Tests\Feature;

use App\Category;
use App\Material;
use App\Supplier;
use Faker\Factory;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class MaterialApiTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Test status code.
     *
     * @return void
     */
    public function testStatusCode()
    {
        $response = $this->json('GET', 'api/materials');
        $response->assertStatus(200);
    }

    /**
     * Test structure json
     */
    public function testListMaterials()
    {
        $this->makeData(10);
        $response = $this->json('GET', 'api/materials');
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'name',
                    'category_id',
                    'supplier_id',
                    'price',
                    'image',
                    'description',
                    'status',
                    'category' => ['id', 'name'],
                    'supplier' => ['id', 'name']
                ]
            ]
        ]);
    }

    /**
     * Test result pagination.
     *
     * @return void
     */
    public function testGetPaginationResult()
    {
        $this->makeData(15);
        $response = $this->json('GET', 'api/materials');
        $response->assertJson([
            'total' => 15,
            'current_page' => 1,
            'per_page' => 10,
            'from' => 1,
            'to' => 10,
            'last_page' => 2
        ])
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'name',
                        'category_id',
                        'supplier_id',
                        'price',
                        'image',
                        'status',
                        'category' => [
                            'id',
                            'name'
                        ],
                        'supplier' => [
                            'id',
                            'name'
                        ]
                    ]
                ]
            ]);
        $response->assertStatus(200);
    }

    /**
     * Test check some object compare database.
     *
     * @return void
     */
    public function testCompareDatabase()
    {
        $this->makeData(2);
        $response = $this->json('GET', 'api/materials');
        $data = json_decode($response->getContent());
        $arrayCompare = [
            'id' => $data->data[0]->id,
            'name' => $data->data[0]->name,
            'category_id' => $data->data[0]->category_id,
            'supplier_id' => $data->data[0]->supplier_id,
            'status' => $data->data[0]->status,
            'price' => $data->data[0]->price
        ];
        $this->assertDatabaseHas('materials', $arrayCompare);
    }

    /**
     * Make data for test.
     *
     * @return void
     */
    public function makeData($row)
    {
        factory(Category::class, 3)->create();
        factory(Supplier::class, 3)->create();
        $faker = Factory::create();
        $categoryIds = Category::all()->pluck('id')->toArray();
        $supplierIds = Supplier::all()->pluck('id')->toArray();
        for ($i = 0; $i < $row; $i++) {
            factory(Material::class, 1)->create(['category_id' => $faker->randomElement($categoryIds),
                'supplier_id' => $faker->randomElement($supplierIds)]);
        }
    }
}