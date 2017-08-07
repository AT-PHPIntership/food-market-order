<?php

namespace App\Http\Controllers;

use Lang;
use Illuminate\Http\Request;
use App\DailyMenu;
use App\Http\Requests\DailyMenu\UpdateMenuItemRequest;

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
        $listDailyMenu = $this->dailyMenu->select('date')->orderBy('date', 'desc')->distinct()->paginate(10);

        return view('daily_menus.index', ['listDailyMenu' => $listDailyMenu]);
    }

    /**
     * Display the specified resource.
     *
     * @param string $date The date to get menu to show
     *
     * @return \Illuminate\Http\Response
     */
    public function show($date)
    {
        $menuOnDate = $this->dailyMenu->with('food.category')->where('date', $date)->paginate(10);

        return view('daily_menus.show', ['menuOnDate' => $menuOnDate, 'date' => $date]);
    }

    /**
     * Update item in Menu List on Date
     *
     * @param UpdateMenuItemRequest $request The request message from Ajax request
     *
     * @return Response
     */
    public function updateMenuItem(UpdateMenuItemRequest $request)
    {
        $quantity = $request['quantity'];
        $menuId = $request['menuId'];
        $dailyMenu = $this->dailyMenu->find($menuId);
        $error = Lang::get('dailymenu.errorEdit');
        $success = Lang::get('dailymenu.successEdit');

        if($dailyMenu->update(['quantity' => $quantity])) {
            $result = [$dailyMenu->updated_at, 'message' => $success];
            return response()->json($result, 200);
        } else {
            return response()->json(['error' => $error], 404);
        }
    }

    /**
     * Delete item in Menu List on Date
     *
     * @param Request $request The request message from Ajax request
     *
     * @return Response
     */
    public function deleteMenuItem(Request $request)
    {
        $menuId = $request['menuId'];
        $error = Lang::get('dailymenu.errorDel');
        $success = Lang::get('dailymenu.successDel');

        if($this->dailyMenu->where('id', $id)->delete()) {
            return response()->json(['message' => $success], 200);
        } else {
            return response()->json(['error' => $error], 404);
        }
    }
}
