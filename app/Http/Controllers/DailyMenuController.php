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
    public function update(UpdateMenuItemRequest $request)
    {
        $quantity = $request['quantity'];
        $menuId = $request['menuId'];
        $dailyMenu = $this->dailyMenu->find($menuId);
        $error = __('Has error during update menu item');
        $success = __('Update menu item success');

        if ($dailyMenu->update(['quantity' => $quantity])) {
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
    public function destroy(Request $request)
    {
        $menuId = $request['menuId'];
        $error = __('Has error during delete menu item');
        $success = __('Delete menu item success');

        if ($this->dailyMenu->where('id', $menuId)->delete()) {
            return response()->json(['message' => $success], 200);
        } else {
            return response()->json(['error' => $error], 404);
        }
    }
}
