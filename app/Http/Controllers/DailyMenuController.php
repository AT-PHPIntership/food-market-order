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
}
