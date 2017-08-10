<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DailyMenu;

class DailyMenuController extends Controller
{
    /**
     * The Daily Menu implementation.
     *
     * @var DailyMenu
     */
    protected $dailyMenu;

    /**
     * Create a new controller instance.
     *
     * @param DailyMenu $dailyMenu instance of DailyMenu
     *
     * @return void
     */
    public function __construct(DailyMenu $dailyMenu)
    {
        $this->dailyMenu = $dailyMenu;
    }

    /**
     * Display a listing of the resource.
     * @param \Illuminate\Http\Request $request request from view
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->has('date')) {
            $listDailyMenu = $this->dailyMenu->select('date')
                                             ->distinct()
                                             ->where('date', $request['date'])
                                             ->orderBy('date', 'desc')
                                             ->paginate(10);
        } else {
            $listDailyMenu = $this->dailyMenu->select('date')->distinct()->orderBy('date', 'desc')->paginate(10);
        }
        return view('daily_menus.index', ['listDailyMenu' => $listDailyMenu, 'date' => $request['date']]);
    }
}
