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
        foreach ($this->getColumns() as $column => $priority) {
            $priority = $priority;
            $query->orWhere($column, "LIKE", "%$keyword%");
        }
    }

    /**
     * Get columns searchable
     *
     * @return mixed
     */
    protected function getColumns()
    {
        $columns = [];
        foreach ($this->searchable['columns'] as $column => $priority) {
            $columns[$column] = $priority;
        }

        /**
         * Sort $columns in descending order, according to the $priority
         */
        arsort($columns);

        return $columns;
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
}
