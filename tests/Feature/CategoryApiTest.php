<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\Category;
use App\Food;
use App\Material;
use App\Supplier;

class CategoryApiTest extends TestCase
{
    use DatabaseTransactions;
    use DatabaseMigrations;

    /**
     * A basic test status code for categories.
     *
     * @return void
     */
    public function testStatusCodeForCategories()
    {
        $response = $this->json('GET', '/api/categories');
        $response->assertStatus(200);
    }

    /**
     * A basic test status code for category detail.
     *
     * @return void
     */
    public function testStatusCodeForCategoryDetail()
    {
        factory(Category::class, 1)->create()->each(function ($c) {
            factory(Supplier::class, 1)->create();
            $c->foods()->save(factory(Food::class)->make());
            $c->materials()->save(factory(Material::class)->make());
        });
        $response = $this->json('GET', '/api/categories/1');
        $response->assertStatus(200);
    }

    /**
     * A basic test status code for get foods by category.
     *
     * @return void
     */
    public function testStatusCodeForFoods()
    {
        $response = $this->json('GET', '/api/categories/1/foods');
        $response->assertStatus(200);
    }

    /**
     * A basic test status code for get materials by category.
     *
     * @return void
     */
    public function testStatusCodeForMaterials()
    {
        $response = $this->json('GET', '/api/categories/1/materials');
        $response->assertStatus(200);
    }

    public function listStructureTest()
    {
    	return [
    		[
    			'url' => '/api/categories',
    			'structure' => [
    				'total',
    				'per_page',
    				'current_page',
    				'last_page',
    				'next_page_url',
    				'path',
    				'prev_page_url',
    				'from',
    				'to',
    				'data' => [
    					[
    						'id', 'name', 'description'
    					]
    				],
    				'success'
    			]
    		],
    		[
    			'url' => '/api/categories/1',
    			'structure' => [
    				'data' => [
    					'id',
    					'name',
    					'description'
    				],
    				'success'
    			]
    		],
    		[
    			'url' => '/api/categories/1/foods',
    			'structure' => [
    				'total',
    				'per_page',
    				'current_page',
    				'last_page',
    				'next_page_url',
    				'path',
    				'prev_page_url',
    				'from',
    				'to',
    				'data' => [
    					[
    						'id', 'name', 'category_id', 'price', 'description', 'image'
    					]
    				],
    				'success'
    			]
    		],
    		[
    			'url' => '/api/categories/1/materials',
    			'structure' => [
    				'total',
    				'per_page',
    				'current_page',
    				'last_page',
    				'next_page_url',
    				'path',
    				'prev_page_url',
    				'from',
    				'to',
    				'data' => [
    					[
    						'id', 'name', 'category_id', 'price', 'description', 'image'
    					]
    				],
    				'success'
    			]
    		]
    	];
    }

    /**
     * @dataProvider listStructureTest
     *
	 */
    public function testJsonStructure($url, $structure)
    {
        factory(Category::class, 1)->create()->each(function ($c) {
    		factory(Supplier::class, 1)->create();
    		$c->foods()->save(factory(Food::class)->make());
    		$c->materials()->save(factory(Material::class)->make());
    	});

        $response = $this->json('GET', $url);
        $response->assertJsonStructure($structure);
    }

    /**
     * A basic test check some object compare database.
     *
     * @return void
     */
    public function testCheckCompareDatabase()
    {
        factory(Category::class, 1)->create()->each(function ($c) {
    		factory(Supplier::class, 1)->create();
    		$c->foods()->save(factory(Food::class)->make());
    		$c->materials()->save(factory(Material::class)->make());
    	});
        //get list category
        $response = $this->json('GET', '/api/categories');
        $data = json_decode($response->getContent());
        $arrayCompare = [
            'name' => $data->data[0]->name,
            'description' => $data->data[0]->description
        ];
        $this->assertDatabaseHas('categories', $arrayCompare);
        //get category detail
        $response = $this->json('GET', '/api/categories/1');
        $data = json_decode($response->getContent());
        $arrayCompare = [
        	'id' => $data->data->id,
        	'name' => $data->data->name,
        	'description' => $data->data->description
        ];
        //get foods by category - same for materials
        $response = $this->json('GET', '/api/categories/1/foods');
        $data = json_decode($response->getContent());
        $arrayCompare = [
        	'name' => $data->data[0]->name,
        	'category_id' => $data->data[0]->category_id,
        	'description' => $data->data[0]->description,
        	'price' => $data->data[0]->price
        ];
    }

    /**
     * A basic test check items per paginate.
     *
     * @return void
     */
    public function testPagination()
    {
    	factory(Category::class, 11)->create()->each(function ($c) {
    		factory(Supplier::class, 1)->create();
    		$c->foods()->save(factory(Food::class)->make(), 11);
    		$c->materials()->save(factory(Material::class)->make(), 11);
    	});	
    	//get list category
        $response = $this->json('GET', '/api/categories');
        $data = json_decode($response->getContent());
        $this->assertEquals(Category::ITEMS_PER_PAGE, $data->per_page);
    }

	/**
     * A basic test check category doesn't exist
     *
     * @return void
     */
    public function testCategoryDoesnotExist()
    {
        $response = $this->json('GET', '/api/categories/1');
        $data = json_decode($response->getContent());
        $this->assertEquals($data->message, __('No query results for model [App\Category] 1'));
    }

    /**
     * A basic test check category doesn't exist
     *
     * @return void
     */
    public function testStructureCategoryDoesnotExist()
    {
        $response = $this->json('GET', '/api/categories/1');
        $response->assertJsonStructure([
        	'message'
        ]);
    }
}
