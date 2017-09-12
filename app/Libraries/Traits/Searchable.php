<?php

namespace App\Libraries\Traits;

use Illuminate\Database\Eloquent\Builder;

trait Searchable
{
    /**
     * Search the result follow the search request and columns searchable
     *
     * @param \Illuminate\Database\Eloquent\Builder $query     query model
     * @param bool                                  $makeWiths to make the relationship
     * @param bool                                  $filter    to filter with specify columns
     * @param bool                                  $order     to make order by specify columns
     *
     * @return void
     */
    public function scopeSearch(Builder $query, $makeWiths = false, $filter = false, $order = false)
    {
        $keyword = request('search');
        $query->select($this->getTable() . '.*');
        $this->makeJoins($query);

        if ($filter) {
            $query->where(function ($subQuery) use ($keyword) {
                foreach ($this->getColumnsSearch() as $column) {
                    $subQuery->orWhere($column, "LIKE", "%$keyword%");
                }
            })->where(function ($subQuery) {
                foreach ($this->getColumnsFilter() as $column => $key) {
                    $subQuery->where($column, 'LIKE', "$key");
                };
            });
        } else {
            foreach ($this->getColumnsSearch() as $column) {
                $query->orWhere($column, "LIKE", "%$keyword%");
            }
        }

        if ($order) {
            foreach ($this->getColumnsOrder() as $column => $byKey) {
                $query = $query->orderBy($column, $byKey);
            }
        }

        if ($makeWiths) {
            $this->makeWiths($query);
        }
    }

    /**
     * Get columns searchable
     *
     * @return mixed
     */
    protected function getColumnsSearch()
    {
        return array_get($this->searchable, 'columns', []);
    }

    /**
     * Get columns filterable
     *
     * @return mixed
     */
    protected function getColumnsFilter()
    {
        $array =  array_get($this->searchable, 'filters', []);
        return $this->unsetIfNullValue($array);
    }

    /**
     * Get columns orderable
     *
     * @return mixed
     */
    protected function getColumnsOrder()
    {
        $array = array_get($this->searchable, 'orders', []);
        return $this->unsetIfNullValue($array);
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
     * @param Builder $query query model
     *
     * @return void
     */
    protected function makeWiths(Builder $query)
    {
        foreach ($this->getWiths() as $table => $keys) {
            $with[$table] = function ($subQuery) use ($keys) {
                $subQuery->select($keys);
            };
            $query->with($with);
        }
    }

    /**
     * Unset element has null value
     *
     * @param Array $array array need to unset null value
     *
     * @return mixed
     */
    protected function unsetIfNullValue($array)
    {
        foreach ($array as $key => $value) {
            if (!isset($value)) {
                unset($array[$key]);
            }
        }
        return $array;
    }

    /**
     * Set search columns for searchable
     *
     * @param Array $array ['column1', 'column2', ...]
     *
     * @return void
     */
    public function setColumnsSearch($array)
    {
        $this->searchable['columns'] = $array;
    }

    /**
     * Set filter columns for searchable
     *
     * @param Array $array ['columns1' => 'value1', 'columns2' => 'value2', ...]
     *
     * @return void
     */
    public function setColumnsFilter($array)
    {
        $this->searchable['filters'] = $array;
    }

    /**
     * Set order-by columns for searchable
     *
     * @param Array $array ['columns1' => 'desc', 'columns2' => 'asc', ...]
     *
     * @return void
     */
    public function setColumnsOrder($array)
    {
        $this->searchable['orders'] = $array;
    }

    /**
     * Set 'joins table for searchable
     *
     * @param Array $array ['table1' => ['key1' => 'ref-key1'], 'table2' => ['key2', 'ref-key2'], ...]
     *
     * @return void
     */
    public function setJoins($array)
    {
        $this->searchable['joins'] = $array;
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
        $this->searchable['withs'] = $array;
    }
}
