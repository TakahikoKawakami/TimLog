<?php

use Illuminate\Database\Seeder;

class TicketsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tickets')->insert([
            'parent_id' => 0,
            'user_id' => 0,
            'text' => 'test ticket',
            'memo' => '',
            'start_date' => '2020-06-01 00:00:00',
            'stop_date' => '2020-06-01 01:02:03',
        ]);
        DB::table('tickets')->insert([
            'parent_id' => 0,
            'user_id' => 0,
            'text' => 'test ticket2',
            'memo' => '',
            'start_date' => '2020-06-01 00:00:00',
            'stop_date' => '2020-06-11 01:02:03',
        ]);
    }
}
