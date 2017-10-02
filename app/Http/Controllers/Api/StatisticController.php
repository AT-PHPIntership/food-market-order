<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Material;
use App\Food;
use App\OrderItem;
use App\Order;
use App\Category;
use App\DailyMenu;
use App\User;
use App\Supplier;

class StatisticController extends ApiController
{
    /**
     * The OrderItem implementation.
     *
     * @var OrderItem
     */
    protected $orderItem;

    /**
     * Create a new controller instance.
     *
     * @param OrderItem $orderItem instance of OrderItem
     *
     * @return void
     */
    public function __construct(OrderItem $orderItem)
    {
        $this->orderItem = $orderItem;
    }

    /**
     * Get count of category, dailymenu, food, material, order, supplier, user.
     *
     * @return \Illuminate\Http\Response
     */
    public function countResources()
    {
        $curDate = date('Y-m-d');
        $counts['categories'] = Category::count();
        $counts['daily_menus'] = DailyMenu::where('date', '=', $curDate)->count();
        $counts['foods'] = Food::count();
        $counts['materials'] = Material::count();
        $counts['orders'] = Order::count();
        $counts['suppliers'] = Supplier::count();
        $counts['users'] = User::count();

        return response()->json(collect(['data' => $counts])->merge(['success' => true]));
    }

    /**
     * Get trends for foods and materials
     *
     * @return \Illuminate\Http\Response
     */
    public function getTrends()
    {
        $topFoods = $this->orderItem->getTrendOrderByModel('App\\Food');
        $topMaterials = $this->orderItem->getTrendOrderByModel('App\\Material');

        if ($topFoods || $topMaterials) {
            return response()->json(collect([
                        'data' => [
                            'foods' => ($topFoods ? $topFoods : ''),
                            'materials' => ($topMaterials ? $topMaterials : '')
                        ]])->merge(['success' => true]));
        }
        $error = __('Has error during access this page');
        return response()->json(['error' => $error], Response::HTTP_NOT_FOUND);
    }
}
