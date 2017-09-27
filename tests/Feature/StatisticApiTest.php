<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class StatisticApiTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * A basic test status code for statistic counts api.
     *
     * @return void
     */
    public function testStatusCodeForCounts()
    {
        $response = $this->json('GET', '/api/statistics/counts');
        $response->assertStatus(200);
    }

    /**
     * A basic test status code for statistic trends api.
     *
     * @return void
     */
    public function testStatusCodeForTrends()
    {
        $response = $this->json('GET', '/api/statistics/trends');
        $response->assertStatus(200);
    }

    /**
     * A basic test json structure for statistic counts api.
     *
     * @return void
     */
    public function testJsonStructureForCounts()
    {
    	//refresh migrate to delete account admin@gmail.com to seed data
    	$this->artisan('migrate:refresh');
        $this->seed('DatabaseSeeder');
        $response = $this->json('GET', '/api/statistics/counts');
        $response->assertJsonStructure([            
            'data' => [
                'categories',
                'daily-menus',
                'foods',
                'materials',
                'orders',
                'suppliers',
                'users'
            ],
            'success'
        ]);
    }

    /**
     * A basic test json structure for statistic trends api.
     *
     * @return void
     */
    public function testJsonStructureForTrends()
    {
        $this->seed('DatabaseSeeder');
        $response = $this->json('GET', '/api/statistics/trends');
        $response->assertJsonStructure([
            'data' => [
                'foods' => [
                    [
                        'id', 'name', 'category_id', 'price', 'image', 'description', 'total_order'
                    ]
                ],
                'materials' => [
                    [
                        'id', 'name', 'category_id', 'price', 'image', 'description', 'total_order'
                    ]
                ]
            ],
            'success'
        ]);
    }

    /**
     * A basic test check some object of counts api compare database.
     *
     * @return void
     */
    public function testCheckCompareDatabaseForCounts()
    {
    	$curDate = date('Y-m-d');
        $response = $this->json('GET', '/api/statistics/counts');
        $data = json_decode($response->getContent())->data;
        $arrayCompare = [
            'categories' => \App\Category::count(),
            'daily-menus' => \App\DailyMenu::where('date', $curDate)->count(),
            'foods' => \App\Food::count(),
            'materials' => \App\Material::count(),
            'orders' => \App\Order::count(),
            'suppliers' => \App\Supplier::count(),
            'users' => \App\User::count()
        ];
        $arrayCompare = (object)$arrayCompare;
        $this->assertEquals($data, $arrayCompare);
    }

    /**
     * A basic test check some object of trends api compare database.
     *
     * @return void
     */
    public function testCheckCompareDatabaseForTrends()
    {
        $response = $this->json('GET', '/api/statistics/trends');
        $data = json_decode($response->getContent())->data;
        $orderItem = new \App\OrderItem;
        $arrayCompare = [
            'foods' => $orderItem->getTrendOrderByModel('App\\Food'),
            'materials' => $orderItem->getTrendOrderByModel('App\\Material')
        ];
        //except out element
        $arrayCompare = json_decode(json_encode($arrayCompare));
        $this->assertEquals($data, $arrayCompare);
    }
}
