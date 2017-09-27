<?php
/**
 * Created by PhpStorm.
 * User: dung
 * Date: 14/09/2017
 * Time: 10:18
 */

namespace App\Libraries\Traits;

trait SearchAndRelationShip
{
    use Searchable;
    use Withs;

    /**
     * Init the searchable and withRelations for custom module get data
     *
     * @param array $array of request need to process
     *
     * @return void
     */
    public function initQueryData($array)
    {
        if (isset($array['search'])) {
            $searchOption = explode('|', $array['search']);
            $this->searchable['keyword'] = $searchOption[0];
            if (isset($searchOption[1])) {
                $this->setColumnsCondition($this->processGetArray($searchOption[1]));
            }
        }

        if (isset($array['filter'])) {
            $this->setColumnsFilter($this->processGetArray($array['filter']));
        }

        if (isset($array['join'])) {
            $this->setJoins($this->processGetArray($array['join']));
        }

        if (isset($array['orderBy'])) {
            $this->setColumnsOrder($this->processGetArray($array['orderBy']));
        }

        if (isset($array['with'])) {
            $this->setWiths($this->processGetArray($array['with']));
        }

        if (isset($array['searchField'])) {
            $this->setColumnsSearch($this->processGetArray($array['searchField']));
        }
    }

    /**
     * The recursive function to precess the request parameter to array use for search and with relations
     *
     * @param string $string        string need to process
     * @param array  $symbols       the list of symbols has ownership, E.g. table*column:valueOfColumn
     * @param bool   $withDetach    true for detach the string, false for process symbols ownership
     * @param array  $detachSymbols the list of detachSymbols need to detach
     *
     * @return mixed
     */
    protected function processGetArray($string, $symbols = ['*', ':'], $withDetach = true, $detachSymbols = [';', '-', '~'])
    {
        if (count($symbols) == 0) {
            if (count($detachSymbols) > 0) {
                $minimumArray = explode($detachSymbols[0], $string);
                return count($minimumArray) > 1 ? $minimumArray : $string;
            }
            return $string;
        }

        if ($withDetach) {
            $detachSymbol = $detachSymbols[0];
            unset($detachSymbols[0]);
            $detachSymbols = array_values($detachSymbols);
            $detaches = explode($detachSymbol, $string);
            $arrayDetaches = [];
            foreach ($detaches as $detach) {
                $result = $this->processGetArray($detach, $symbols, !$withDetach, $detachSymbols);
                if (!is_array($result)) {
                    $result = [$result];
                }
                $arrayDetaches = array_merge($arrayDetaches, $result);
            }
            return $arrayDetaches;
        } else {
            $key = [];
            $symbol = $symbols[0];
            unset($symbols[0]);
            $symbols = array_values($symbols);
            $temp = explode($symbol, $string);
            if (count($temp) > 1) {
                $key = $temp[0];
                $temp[0] = $temp[1];
            }
            $string = $temp[0];
            return $key == [] ? $this->processGetArray($string, $symbols, !$withDetach, $detachSymbols) : [$key => $this->processGetArray($string, $symbols, !$withDetach, $detachSymbols)];
        }
    }

    /**
     * Unset element has null value
     *
     * @param array $array array need to unset null value
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
}
