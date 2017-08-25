<?php

namespace App\Libraries\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

trait AjaxSearchable
{
    /**
     * Search the result follow the ajax request and columns searchable
     *
     * @param \Illuminate\Database\Eloquent\Builder $query   query model
     * @param \Illuminate\Http\Request              $request request value
     *
     * @return void
     */
    public function scopeAjaxSearch(Builder $query, Request $request)
    {
        $table = $this->getTable();
        $query->select($this->getTable() . '.*');
        $this->ajMakeJoins($query);
        foreach ($request->all() as $key => $value) {
            foreach ($this->ajGetColumns() as $column) {
                if ($table.'.'.$key == $column) {
                    if (strpos($key, '_id')>-1) {
                        $query->Where($column, "=", "$value");
                        break;
                    }
                    $query->orWhere($column, "LIKE", "%$value%");
                    break;
                }
            }
        }
    }

    /**
     * Get columns ajaxSearchable
     *
     * @return mixed
     */
    protected function ajGetColumns()
    {
        return array_get($this->ajaxSearchable, 'columns', []);
    }

    /**
     * Get joins
     *
     * @return mixed
     */
    protected function ajGetJoins()
    {
        return array_get($this->ajaxSearchable, 'joins', []);
    }

    /**
     * Make joins
     *
     * @param Builder $query query model
     *
     * @return void
     */
    protected function ajMakeJoins(Builder $query)
    {
        foreach ($this->ajGetJoins() as $table => $keys) {
            $query->leftJoin($table, function ($join) use ($keys) {
                $join->on($keys[0], '=', $keys[1]);
            });
        }
    }
}
