<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\DailyMenu;
use App\Category;
use App\Food;

class DailyMenuAPIController extends Controller
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
    public function __construct(DailyMenu $dailyMenu, Food $food, Category $category)
    {
        $this->dailyMenu = $dailyMenu;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dailyMenus = $this->dailyMenu->search()->select('date')->distinct()->orderBy('date', 'DESC')->paginate(DailyMenu::ITEMS_PER_PAGE);
        return response()->json(['data' => $dailyMenus], Response::HTTP_OK);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $date = $request['date'];
        $dailyMenus = $this->dailyMenu->with('food.category')->where('date', $date)->paginate($this->dailyMenu->ITEMS_PER_PAGE);
        return response()->json(['data' => $dailyMenus], Response::HTTP_OK);
    }
}
