<?php

use Carbon\Carbon;
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
        $time_now = Carbon::now();
        DB::table('languages')->insert([
            'name'        => 'English',
            'code'        => 'en',
            'keywords'    => '',
            'description' => '',
            'status'      => 'on',
            'created_at'  => $time_now,
            'updated_at'  => $time_now,
        ]);
    }
}
