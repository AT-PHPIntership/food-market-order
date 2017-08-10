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
     *
     * @param \Illuminate\Http\Request $request request from view
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $dailyMenus = $this->dailyMenu->select('date');
        if ($request->has('date')) {
            $dailyMenus = $dailyMenus->where('date', 'like', '%'.$request['date'].'%');
        }
        $dailyMenus = $dailyMenus->distinct()->orderBy('date', 'desc')->paginate(10);
        return view('daily_menus.index', ['dailyMenus' => $dailyMenus, 'date' => $request['date']]);
    }
}
