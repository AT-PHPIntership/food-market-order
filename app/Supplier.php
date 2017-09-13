<?php

namespace App;

use App\Libraries\Traits\Searchable;
use App\Libraries\Traits\Deletable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Supplier extends Model
{
    use softDeletes;
    use Searchable;
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
            'materials'
        ]
    ];

    /**
     * Supplier has many materials
     *
     * @return mixed
     */
    public function materials()
    {
        return $this->hasMany('App\Material', 'supplier_id', 'id');
    }
}
