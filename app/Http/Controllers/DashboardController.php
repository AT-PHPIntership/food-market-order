<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DailyMenu;
use App\Material;
use App\Order;
use App\User;
use Carbon\Carbon;

class DashboardController extends Controller
{
    protected $curDate;

    /**
     * Create a new controller instance.
     *
     * @param Carbon\Carbon $carbon carbon instance
     *
     * @return void
     */
    public function __construct(Carbon $carbon)
    {
        $carbon = $carbon->today();
        $format = $carbon->format('Y-m-d');
        $this->curDate = $format;
    }

    /**
     * Get total of new order, register, ... on day
     *
     * @param string $modelType type of model
     *
     * @return int
     */
    public function getTotalOf($modelType)
    {
        $total = $modelType::where('created_at', 'like', '%'.$this->curDate.'%')->count();
        return $total;
    }

    /**
     * Get total of new register on day
     *
     * @return Integer
     */
    public function getStatistics()
    {
        $statistics = new \stdClass();
        $statistics->totalOrder = $this->getTotalOf('App\\Order');
        $statistics->totalRegister = $this->getTotalOf('App\\User');
        $statistics->totalFood = DailyMenu::where('date', '=', $this->curDate)->count();
        $statistics->totalMaterial = Material::count();
        $statistics->date = $this->curDate;

        return $statistics;
    }

    public function topOrder()
    {
        $user = new User;
        return $user->topUserActive();
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $statistics = $this->getStatistics();

        return view('dashboard', ['statistics' => $statistics]);
    }
}
