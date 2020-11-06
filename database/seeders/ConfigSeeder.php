<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class ConfigSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('configs')->insert([
            'title'=>"Code Hocasu",
            'created_at'=>now(),
            'updated_at'=>now()
        ]);
    }
}
