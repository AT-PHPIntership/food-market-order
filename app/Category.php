<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use softDeletes;
    const ITEMS_PER_PAGE = 10;

    protected $fillable = [
        'name',
        'description'
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
