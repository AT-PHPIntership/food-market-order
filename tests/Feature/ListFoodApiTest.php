<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;
use Faker\Factory as Faker;
use App\Category;
use App\Food;

class ListFoodApiTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * Test status code.
     *
     * @return void
     */
    public function testStatusCode()
    {
        $response = $this->json('GET', 'api/foods');
        $response->assertStatus(200);
    }

    /**
     * Test structure
     *
     * @return void
     */
    public function testStructureJson()
    {
        Artisan::call('migrate:refresh');
        $this->makeData(5);
        $response = $this->json('GET', 'api/foods');
        $response->assertJsonStructure([
            'data'=> [
                '*' => [
                    'id',
                    'name',
                    'category_id',
                    'price',
                    'image',
                    'category' => [
                        'id',
                        'name'
                    ],
                ],
            ],
        ]);
    }

    /**
     * Test result pagination.
     *
     * @return void
     */
    public function testGetPaginationResult()
    {
        Artisan::call('migrate:refresh');
        $this->makeData(15);
        $response = $this->json('GET', 'api/foods');
        $response->assertJson([
            'total' => 15,
            'current_page' => 1,
            'per_page' => 10,
            'from' => 1,
            'to' => 10,
            'last_page' => 2
        ])
            ->assertJsonStructure([
            'data'=> [
                '*' => [
                    'id',
                    'name',
                    'category_id',
                    'price',
                    'image',
                    'category' => [
                        'id',
                        'name'
                    ],
                ],
            ],
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
        Artisan::call('migrate:refresh');
        $this->makeData(2);
        $response = $this->json('GET', 'api/foods');
        $data = json_decode($response->getContent());
        $arrayCompare = [
            'id' => $data->data[0]->id,
            'name' => $data->data[0]->name,
            'category_id' => $data->data[0]->category_id,
            'price' => $data->data[0]->price,
        ];
        $this->assertDatabaseHas('foods', $arrayCompare);
    }

    /**
     * Make data for test.
     *
     * @return void
     */
    public function makeData($row)
    {
        factory(Category::class, 10)->create();
        $categoryIds = Category::all('id')->pluck('id')->toArray();
        $faker = Faker::create();
        for ($i = 0; $i < $row; $i++) {
            factory(Food::class, 1)->create([
                'category_id' => $faker->randomElement($categoryIds),
            ]);
        }
    }
}
