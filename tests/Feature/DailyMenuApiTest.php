<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Category;
use App\Food;
use App\DailyMenu;

class DailyMenuApiTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * A basic test status code for daily menu detail.
     *
     * @return void
     */
    public function testStatusCode()
    {
        $response = $this->json('GET', '/api/daily-menus/2017-09-14');
        $response->assertStatus(200);
    }

    /**
     * A basic test json structure for daily menu detail.
     *
     * @return void
     */
    public function testJsonStructure()
    {
        factory(Category::class, 1)->create()->each(function ($c) {
            $c->foods()->save(factory(Food::class)->make());
        });
        factory(DailyMenu::class, 1)->create(['food_id' => 1, 'date' => '2017-09-15']);

        $response = $this->json('GET', '/api/daily-menus/2017-09-15');
        $response->assertJsonStructure([            
            'current_page',
            'data' => [[
                'date',
                'food_id',
                'quantity',
                'food' => [
                    'id',
                    'name',
                    'price',
                    'description',
                    'category_id',
                    'image',
                    'category' => [
                        'id',
                        'name',
                        'description'
                    ]
                ]
            ]],
            'from',
            'last_page',
            'next_page_url',
            'path',
            'per_page',
            'prev_page_url',
            'to',
            'total',
            'success'
        ]);
    }

    /**
     * A basic test check some object compare database.
     *
     * @return void
     */
    public function testCheckCompareDatabase()
    {
        factory(Category::class, 1)->create()->each(function ($c) {
            $c->foods()->save(factory(Food::class)->make());
        });
        factory(DailyMenu::class, 1)->create(['food_id' => 1, 'date' => '2017-09-15']);

        $response = $this->json('GET', '/api/daily-menus/2017-09-15');
        $data = json_decode($response->getContent());
        $arrayCompare = [
            'date' => $data->data[0]->date,
            'food_id' => $data->data[0]->food_id,
            'quantity' => $data->data[0]->quantity
        ];
        $this->assertDatabaseHas('daily_menus', $arrayCompare);
    }
}
