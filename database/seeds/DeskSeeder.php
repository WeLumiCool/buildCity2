<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DeskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('desks')->truncate();
        factory(App\Desk::class, 20)->create();
    }
}
