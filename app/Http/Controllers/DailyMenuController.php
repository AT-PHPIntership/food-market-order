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
     * @param Food $food instance of Food
     * @param Category $category instance of Category
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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $listCategory = $this->category->get();
        if ($request->ajax()){
            $category = $request->category;
            $listFood = $this->food->where('category_id', $category)->get();
            return response()->json($listFood);
        }
        if ($request->has('date')) {
            return view('daily_menus.create', ['listCategory' => $listCategory, 'date' => $request['date']]);
        }
        return view('daily_menus.create', ['listCategory' => $listCategory]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\DailyMenu\CreateRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateRequest $request)
    {
        $date = $request['date'];
        $food_id = $request['food_id'];
        $quantity = $request['quantity'];

        /**
         * Check if food has existed in DB, if true then add new quantity with old quantity,
         * If false then add this food into menu
         */
        if (sizeof($this->dailyMenu->where('date', $date)->where('food_id', $food_id))>1) {
            $old_quantity = $this->dailyMenu
                                 ->where('date', $date)
                                 ->where('food_id', $food_id)
                                 ->get()[0]['quantity'];
            $quantity += $old_quantity;
            $status = $this->dailyMenu->where('food_id', $food_id)->update(['quantity' => $quantity]);
        } else {
            $menu_item = new DailyMenu;
            $menu_item->date = $date;
            $menu_item->food_id = $food_id;
            $menu_item->quantity = $quantity;
            $status = $menu_item->save();
        }

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
