<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DailyMenu;
use App\Http\Requests\DailyMenu\CreateRequest;
use App\Category;

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
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $listDailyMenu = $this->dailyMenu->select('date')->distinct()->orderBy('date', 'desc')->paginate(10);
        
        return view('daily_menus.index', ['listDailyMenu' => $listDailyMenu]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $listCategory = Category::getAll();
        if ($request->ajax()){
            $category = $request->category;
            $listFood = Food::where('category_id', $category)->get();
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateRequest $request)
    {
        $date = $request['date'];
        $food_id = $request['food_id'];
        $quantity = $request['quantity'];

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
        $listCategory = Category::getAll();
        return redirect()->route('daily-menus.create', ['date' => $date]);
    }
}
