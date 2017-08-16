<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DailyMenu;
use App\Category;
use App\Food;
use App\Http\Requests\DailyMenu\CreateRequest;

class DailyMenuController extends Controller
{
    /**
     * The Daily Menu implementation.
     *
     * @var DailyMenu
     */
    protected $dailyMenu;
    /**
     * The Food implementation.
     *
     * @var Food
     */
    protected $food;
    /**
     * The Category implementation.
     *
     * @var Category
     */
    protected $category;

    /**
     * Create a new controller instance.
     *
     * @param DailyMenu $dailyMenu instance of DailyMenu
     * @param Food      $food      instance of Food
     * @param Category  $category  instance of Category
     *
     * @return void
     */
    public function __construct(DailyMenu $dailyMenu, Food $food, Category $category)
    {
        $this->dailyMenu = $dailyMenu;
        $this->food = $food;
        $this->category = $category;
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

    /**
     * Show the form for creating a new resource.
     *
     * @param \Illuminate\Http\Request $request request value
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $listCategory = $this->category->get();
        if ($request->ajax()) {
            $categoryId = $request->category_id;
            $listFood = $this->food->where('category_id', $categoryId)->paginate(10);
            return response()->json($listFood);
        } elseif ($request->has('date')) {
            return view('daily_menus.create', ['listCategory' => $listCategory, 'date' => $request['date']]);
        }
        return view('daily_menus.create', ['listCategory' => $listCategory]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param App\Http\Requests\DailyMenu\CreateRequest $request request value
     *
     * @return \Illuminate\Http\Response
     */
    public function store(CreateRequest $request)
    {
        $date = $request['date'];
        $foodId = $request['food_id'];
        $quantity = $request['quantity'];
        /**
         * Check if food has existed in DB, if true then update new quantity,
         * If false then add this food into menu
         */
        $matchDailyMenu = array('date' => $date, 'food_id' => $foodId);
        $status = $this->dailyMenu->updateOrCreate($matchDailyMenu, ['quantity' => $quantity]);

        if ($status) {
            $request->session()->flash('message.level', 'success');
            $request->session()->flash('message.content', __('Menu was successfully added!'));
        } else {
            $request->session()->flash('message.level', 'danger');
            $request->session()->flash('message.content', __('Error'));
        }
        return redirect()->route('daily-menus.create', ['date' => $date]);
    }
}
