<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\DailyMenu;
use App\Material;
use App\Order;
use App\User;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Current date
     *
     * @var string
     */
    protected $currentDate;

    /**
     * The User implementation.
     *
     * @var User
     */
    protected $user;

    /**
     * Create a new controller instance.
     *
     * @param Carbon\Carbon $carbon carbon instance
     * @param User          $user   user instance
     *
     * @return void
     */
    public function __construct(Carbon $carbon, User $user)
    {
        $carbon = $carbon->today();
        $format = $carbon->format('Y-m-d');
        $this->currentDate = $format;
        $this->user = $user;
    }

    /**
     * Get Statistics of Order, register, food in menu, total material on day
     *
     * @return \stdObject
     */
    public function getStatistics()
    {
        $statistics = new \stdClass();
        $statistics->totalOrder = Order::getTotalOnDate($this->currentDate)->count();
        $statistics->totalRegister = User::getTotalOnDate($this->currentDate)->count();
        $statistics->totalFood = DailyMenu::where('date', '=', $this->currentDate)->count();
        $statistics->totalMaterial = Material::count();
        $statistics->users = $this->user->topUserActive();
        $statistics->date = $this->currentDate;

        return $statistics;
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
