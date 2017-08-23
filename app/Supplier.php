<?php

namespace App;

use App\Libraries\Traits\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Supplier extends Model
{
    use softDeletes;
    use Searchable;

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
     * Supplier has many materials
     *
     * @return mixed
     */
    public function materials()
    {
        return $this->hasMany('App\Material', 'category_id', 'id');
    }
}
