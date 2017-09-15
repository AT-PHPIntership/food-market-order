<?php

namespace App;

use App\Libraries\Traits\SearchAndRelationShip;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SearchAndRelationShip;
    use softDeletes;

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
        static::deleting(function ($category) {
            $category->foods()->delete();
            $category->materials()->delete();
        });
    }
}
