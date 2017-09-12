<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\DailyMenu;
use App\Order;
use App\Material;

class StatisticController extends Controller
{
	protected $curDate;

	/**
     * Create a new controller instance.
     *
     * @param string $date current date
     *
     * @return void
     */
    public function __construct($date)
    {
   		$this->curDate = $date;
    }

    /**
     * Get total of new order on day
     *
     * @return int
     */
    public function getTotalOrders()
    {
    	
    }

    /**
     * Get total of new register on day
     *
     * @return Integer
     */
    public function getTotalRegisters()
    {

    }

    /**
     * Get total of daily menu on day
     *
     * @return Integer
     */
    public function getTotalDailyMenus()
    {

    }

    /**
     * Get total of material ready in storage
     *
     * @return Integer
     */
    public function getTotalMaterials()
    {

    }
}
