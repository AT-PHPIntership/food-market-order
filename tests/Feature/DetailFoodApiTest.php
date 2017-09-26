<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Faker\Factory as Faker;
use App\Category;
use App\Food;

class DetailFoodApiTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * Test status code.
     *
     * @return void
     */
    public function testStatusCode()
    {
        $this->makeData(5);
        $response = $this->json('GET', 'api/foods/1');
        $response->assertStatus(200);
    }

    /**
     * Test status code.
     *
     * @return void
     */
    public function testStructJson()
    {
        $this->makeData(5);
        $response = $this->json('GET', 'api/foods/1');
        $response->assertJsonStructure([
                'id',
                'name',
                'category_id',
                'price',
                'image',
                'category' => [
                    'id',
                    'name'
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
        $this->makeData(2);
        $response = $this->json('GET', 'api/foods/1');
        $data = json_decode($response->getContent());
        $arrayCompare = [
            'id' => $data->id,
            'name' => $data->name,
            'category_id' => $data->category_id,
            'price' => $data->price,
        ];
        $this->assertDatabaseHas('foods', $arrayCompare);
    }
    
    /**
     * Test status code fail
     *
     * @return void
     */
    public function testFailStatus()
    {
        $response = $this->json('GET', 'api/foods/10');
        $response->assertStatus(404);
        $response->assertJsonStructure([
            'message'
            ]);
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
