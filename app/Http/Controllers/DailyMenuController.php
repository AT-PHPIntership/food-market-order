<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DailyMenu;
use App\Food;

class DailyMenuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $listDailyMenu = DailyMenu::getAll();

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
        $menuOnDate = DailyMenu::getMenu($date);

        return view('daily_menus.show', ['menuOnDate' => $menuOnDate, 'date' => $date]);
    }

    /**
     * Update item in Menu List on Date
     *
     * @param Request $request The request message from Ajax request
     *
     * @return Response
     */
    public function updateMenuItem(Request $request)
    {
        $menuItem = $request->data[0];
        $quantity = $menuItem['newQuantity'];
        $menuId = $menuItem['menuId'];
        $dailyMenu = DailyMenu::find($menuId);
        $dailyMenu->quantity = $quantity;

        if ($dailyMenu->save()) {
            $result = array("status" => 1, "updated_at" => $dailyMenu->updated_at);
            return $result;
        } else {
            return "Has error during update new quantity";
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
        $menuId = $request->data;

        if (DailyMenu::deleteMenuItem($menuId)) {
            return 1;
        } else {
            return "Has error during delete this menu item";
        }
    }
}
