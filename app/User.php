<?php

namespace App;

use App\Libraries\Traits\Searchable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\HasApiTokens;
use Illuminate\Support\Facades\DB;
use App\Libraries\Traits\NewestStatistic;

class User extends Authenticatable
{
    use HasApiTokens;
    use Notifiable;
    use SoftDeletes;
    use Searchable;
    use NewestStatistic;

    const MALE = 1;
    const FEMALE = 0;
    const ADMIN = 1;
    const NORMAL_USER = 0;
    const ITEMS_PER_PAGE = 10;
    const TOP_ACTIVE = 3;

    /**
     * Searchable rules.
     *
     * @var array
     */
    protected $searchable = [

        'columns' => [
            'full_name',
            'email',
            'birthday',
            'address',
            'phone_number',
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
     * Get Image Attribute
     *
     * @param string $image get attribute image
     *
     * @return string
     */
    public function getImageAttribute($image)
    {
        if ($image) {
            return asset(config('constant.path_upload_users') . $image);
        } else {
            return asset(config('constant.default_image'));
        }
    }

    /**
     * Get Users have most total order
     *
     * @return object
     */
    public function topUserActive()
    {
        $users = self::withCount([
                'orders',
                'orders as pending_orders' => function ($pendingQuery) {
                    $pendingQuery->where('status', Order::STATUS_PENDING);
                },
                'orders as canceled_orders' => function ($canceledQuery) {
                    $canceledQuery->where('status', Order::STATUS_CANCELED);
                },
                'orders as approved_orders' => function ($approvedQuery) {
                    $approvedQuery->where('status', Order::STATUS_APPROVED);
                },
                'orders as finished_orders' => function ($finishedQuery) {
                    $finishedQuery->where('status', Order::STATUS_FINISHED);
                }
            ])->orderBy('orders_count', 'desc')->take(self::TOP_ACTIVE)->get();

        return $users;
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
         * Register a creating model event with the dispatcher.
         *
         * @param \Closure|string $callback
         *
         * @return void
         */
        static::creating(function ($user) {
            if (Hash::needsRehash($user->password)) {
                $user->password = bcrypt($user->password);
            }
        });

        /**
         * Register an updating model event with the dispatcher.
         *
         * @param \Closure|string $callback
         *
         * @return void
         */
        static::updating(function ($user) {
            if (Hash::needsRehash($user->password)) {
                $user->password = bcrypt($user->password);
            }
        });

        /**
         * Register a deleting model event with the dispatcher.
         *
         * @param \Closure|string $callback
         *
         * @return void
         */
        static::deleting(function ($user) {
            $user->orders()->delete();
        });
    }
}
