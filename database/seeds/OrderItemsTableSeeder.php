<?php

use Illuminate\Database\Seeder;

class OrderItemsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        factory(App\Order::class, 50)->create()->each(function ($order){
            factory(App\OrderItem::class, random_int(1,5))->create(['order_id' => $order->id,]);
        });
    }
}
