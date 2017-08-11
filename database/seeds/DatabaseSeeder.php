<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersTableSeeder::class);
        $this->call(SuppliersTableSeeder::class);
        $this->call(CategoriesTableSeeder::class);
        $this->call(FoodsTableSeeder::class);
        $this->call(DailyMenusTableSeeder::class);
        $this->call(MaterialsTableSeeder::class);
        $this->call(OrderItemsTableSeeder::class);
    }
}
