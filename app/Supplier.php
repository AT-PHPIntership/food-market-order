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
}
