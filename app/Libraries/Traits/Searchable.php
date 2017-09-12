<?php

namespace App\Libraries\Traits;

use Illuminate\Database\Eloquent\Builder;

trait Searchable
{
    /**
     * Search the result follow the search request and columns searchable
     *
     * @param \Illuminate\Database\Eloquent\Builder $query query model
     *
     * @return void
     */
    public function scopeSearch(Builder $query)
    {
        $query->select($this->getTable() . '.*');
        $this->makeJoins($query);

        $keyword = request('search');
        foreach ($this->getColumns() as $column) {
            $query->orWhere($column, "LIKE", "%$keyword%");
        }

        $this->makeWiths($query);
    }

    /**
     * Get columns searchable
     *
     * @return mixed
     */
    protected function getColumns()
    {
        return array_get($this->searchable, 'columns', []);
    }

    /**
     * Get joins
     *
     * @return mixed
     */
    protected function getJoins()
    {
        return array_get($this->searchable, 'joins', []);
    }

    /**
     * Get withs
     *
     * @return mixed
     */
    protected function getWiths()
    {
        return array_get($this->searchable, 'withs', []);
    }

    /**
     * Make joins
     *
     * @param Builder $query query model
     *
     * @return void
     */
    protected function makeJoins(Builder $query)
    {
        foreach ($this->getJoins() as $table => $keys) {
            $query->leftJoin($table, function ($join) use ($keys) {
                $join->on($keys[0], '=', $keys[1]);
            });
        }
    }

    /**
     * Make withs
     *
     * @param Builder $query
     */
    protected function makeWiths(Builder $query)
    {
        foreach ($this->getWiths() as $table => $keys) {
            $with[$table] = function ($query1) use ($keys){
                $query1->select($keys);
            };
            $query->with($with);
        }
    }
}
