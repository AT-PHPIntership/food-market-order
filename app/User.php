<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Libraries\Traits\Searchable;

class User extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;
    use Searchable;

    const MALE = 1;
    const FEMALE = 0;
    const ADMIN = 1;
    const NORMAL_USER = 0;
    const ITEMS_PER_PAGE = 10;

    /**
     * Searchable rules.
     *
     * @var array
     */
    protected $searchable = [
        /**
         * Columns and their priority in search results.
         * Columns with higher values are more important.
         * Columns with equal values have equal importance.
         */

        'columns' => [
            'full_name' => 10,
            'email' => 8,
            'birthday' => 5,
            'address' => 2,
            'phone_number' => 2,
        ]
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'full_name',
        'email',
        'password',
        'image',
        'address',
        'birthday',
        'gender',
        'phone_number',
        'is_active',
        'is_admin',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * User has many orders
     *
     * @return mixed
     */
    public function orders()
    {
        return $this->hasMany(Order::class, 'user_id', 'id');
    }

    /**
     * This is a recommended way to declare event handlers
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($user) {
            $user->password = bcrypt($user->password);
        });

        static::deleting(function ($user) {
            $user->orders()->delete();
        });
    }
}
