<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Supplier extends Model
{
    use softDeletes;
    const ITEM_PER_PAGE = 10;
    protected $fillable = [
        'name',
        'description'
    ];

    /**
     * Supplier has many materials
     *
     * @return Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function materials()
    {
        return $this->hasMany('App\Material', 'category_id', 'id');
    }
}
