<?php

use Illuminate\Database\Seeder;

class insert_list_menu_table extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        App\list_menu::create([
                'tittle' => "dashhboard",	
            ]);
    }
}
