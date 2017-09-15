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
        $this->makeSearch($query);
        $this->makeFilters($query);
        $this->makeOrderBy($query);
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
     * Get columns condition
     *
     * @return mixed
     */
    protected function getColumnsCondition()
    {
        $array = array_get($this->searchable, 'conditions', []);
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
     * Get columns orderable
     *
     * @return mixed
     */
    protected function getColumnsFilter()
    {
        $array = array_get($this->searchable, 'filters', []);
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
     * Set search columns for searchable
     *
     * @param array $array [ 'table1' => ['column1', 'column2', ...], 'table2' => ['column3', 'column4', ...], ...]
     *
     * @return void
     */
    public function setColumnsSearch($array)
    {
        $this->searchable['columns'] = $array;
    }

    /**
     * Set condition columns for condition search
     *
     * @param array $array [ 'table1' => ['column1', 'column2', ...], 'table2' => ['column3', 'column4', ...], ...]
     *
     * @return void
     */
    public function setColumnsCondition($array)
    {
        $this->searchable['conditions'] = $array;
    }

    /**
     * Set order-by columns for order by
     *
     * @param array $array ['table1' => ['columns1' => 'desc', 'columns2' => 'asc', ...], 'table2' => ['columns1' => 'desc', 'columns2' => 'asc', ...], ...]
     *
     * @return void
     */
    public function setColumnsOrder($array)
    {
        $this->searchable['orders'] = $array;
    }

    /**
     * Set order-by columns for filter
     *
     * @param array $array ['columns1' => 'desc', 'columns2' => 'asc', ...]
     *
     * @return void
     */
    public function setColumnsFilter($array)
    {
        $this->searchable['filters'] = $array;
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
     * Make joins
     *
     * @param Builder $query query model
     *
     * @return void
     */
    protected function makeJoins(Builder $query)
    {
        foreach ($this->getJoins() as $table => $foreign) {
            $query->leftJoin($table, function ($join) use ($table, $foreign) {
                foreach ($foreign as $key => $foreignKey) {
                    $join->on($this->getTable() . '.' . $key, '=', $table . '.' . $foreignKey);
                }
            });
        }
    }

    /**
     * Make order by
     *
     * @param Builder $query query model
     *
     * @return void
     */
    protected function makeOrderBy(Builder $query)
    {
        foreach ($this->getColumnsOrder() as $key => $value) {
            if (is_array($value)) {
                foreach ($value as $column => $orderType) {
                    $query = $query->orderBy($key . '.' . $column, $orderType);
                }
            } else {
                $query = $query->orderBy($this->getTable() . '.' . $key, $value);
            }
        }
    }

    /**
     * Make search
     *
     * @param Builder $query query model
     *
     * @return void
     */
    protected function makeSearch(Builder $query)
    {
        $keyword = request('search');
        if (isset($this->searchable['keyword'])) {
            $keyword = $this->searchable['keyword'];
        }
        $query->where(function ($subQuery) use ($keyword) {
            foreach ($this->getColumnsSearch() as $key => $value) {
                if (is_array($value)) {
                    foreach ($value as $column) {
                        $subQuery->orWhere($key . '.' . $column, "LIKE", "%$keyword%");
                    }
                } else {
                    $subQuery->orWhere($this->getTable() . '.' . $value, "LIKE", "%$keyword%");
                }
            }
        })->where(function ($subQuery) {
            foreach ($this->getColumnsCondition() as $key => $value) {
                if (is_array($value)) {
                    foreach ($value as $column => $valueColumn) {
                        $subQuery->where($key . '.' . $column, 'LIKE', "$valueColumn");
                    }
                } else {
                    $subQuery->where($this->getTable() . '.' . $key, 'LIKE', "$value");
                }
            };
        });
    }

    /**
     * Make filter
     *
     * @param Builder $query query model
     *
     * @return void
     */
    protected function makeFilters(Builder $query)
    {
        $filters = [];
        foreach ($this->getColumnsFilter() as $key => $value) {
            if (is_array($value)) {
                foreach ($value as $column) {
                    array_push($filters, $key . '.' . $column);
                }
            } else {
                array_push($filters, $this->getTable() . '.' . $value);
            }
        }
        if ($filters == []) {
            return;
        }
        $query->select($filters);
    }
}
