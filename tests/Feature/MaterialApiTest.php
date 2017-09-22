<?php
/**
 * Created by PhpStorm.
 * User: dungvand
 * Date: 21/09/17
 * Time: 15:28
 */

namespace Tests\Feature;

use App\Material;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class MaterialApiTest extends TestCase
{
    use DatabaseTransactions;

    public function testListMaterials()
    {
        factory(Material::class, 1)->create();
        $response = $this->json('GET', 'api/materials');
        $response->assertJsonStructure([
            'current_page',
            'data' => [
                0 => [
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
            ],
            'from',
            'last_page',
            'next_page_url',
            'path',
            'per_page',
            'prev_page_url',
            'to',
            'total'
        ]);
    }
}