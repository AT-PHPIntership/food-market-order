<?php

namespace App\Libraries\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

trait NewestStatistic
{
    /**
     * Get total of new order, register, ... on day
     *
     * @param \Illuminate\Database\Eloquent\Builder $query query model
     * @param string                                $date  date of request
     *
     * @return int
     */
    public function scopeGetTotalOnDate($query, $date)
    {
        $total = $query->where('created_at', 'like', "%{$date}%");
        return $total;
    }
}
