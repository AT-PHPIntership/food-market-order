<?php

namespace App;

use App\Libraries\Traits\SearchAndRelationShip;
use App\Libraries\Traits\Deletable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SearchAndRelationShip;
    use softDeletes;
    use Deletable;

    const ITEMS_PER_PAGE = 10;

    protected $fillable = [
        'name',
        'description'
    ];

    /**
     * Searchable rules.
     *
     * @var array
     */
    protected $searchable = [

        'columns' => [
            'name',
            'description',
        ]
    ];

    /**
     * Relates model.
     *
     * @var array
     */
    protected $relates = [

        'relates' => [
            'foods',
            'materials',
        ]
    ];

    protected $dates = ['deleted_at'];
    
    /**
     * Category has many foods
     *
     * @return mixed
     */
    public function foods()
    {
        return $this->hasMany('App\Food', 'category_id', 'id');
    }

    /**
     * Category has many materials
     *
     * @return mixed
     */
    public function materials()
    {
        return $this->hasMany('App\Material', 'category_id', 'id');
    }
}
