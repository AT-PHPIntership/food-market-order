<?php

use Illuminate\Database\Seeder;

class DailyMenusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        factory(App\DailyMenu::class, 50)->create();
    }
}
