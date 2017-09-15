<?php

namespace App;

use App\Libraries\Traits\SearchAndRelationShip;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Supplier extends Model
{
    use softDeletes;
    use SearchAndRelationShip;

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
        return $this->hasMany('App\Material', 'supplier_id', 'id');
    }

    /**
     * This is a recommended way to declare event handlers
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        /**
         * Register a deleting model event with the dispatcher.
         *
         * @param \Closure|string  $callback
         *
         * @return void
         */
        static::deleting(function ($supplier) {
            $supplier->materials()->delete();
        });
    }
}
