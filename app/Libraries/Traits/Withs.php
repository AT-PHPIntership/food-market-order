<?php
/**
 * Created by PhpStorm.
 * User: dung
 * Date: 14/09/2017
 * Time: 10:10
 */

namespace App\Libraries\Traits;

use Illuminate\Database\Eloquent\Builder;

trait Withs
{
    /**
     * Make with relations follow request
     *
     * @param Builder $query query model
     *
     * @return void
     */
    public function scopeWiths(Builder $query)
    {
        $this->makeWiths($query, $this->getWiths());
    }

    /**
     * Make with relations
     *
     * @param Query $query query injection
     * @param array $withs array of with relations
     *
     * @return void
     */
    protected function makeWiths($query, $withs)
    {
        foreach ($withs as $table => $keys) {
            $with[$table] = function ($subQuery) use ($keys) {
                foreach ($keys as $key => $value) {
                    if (is_array($value)) {
                        $this->makeWiths($subQuery, [$key => $value]);
                        unset($keys[$key]);
                    }
                    $subQuery->select($keys);
                }
            };
            $query->with($with);
        }
    }

    /**
     * Get withs
     *
     * @return mixed
     */
    protected function getWiths()
    {
        return isset($this->withRelations) ? $this->withRelations : [];
    }

    /**
     * Set relationship table for searchable
     *
     * @param Array $array ['relation1' => ['column1', 'column2', ...], 'relation2' => ['column1', 'column2', ...], ...]
     *
     * @return void
     */
    public function setWiths($array)
    {
        $this->withRelations = $array;
    }
}
