<?php

use Illuminate\Database\Seeder;

class TicketDisplaySequenceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('ticket_display_sequences')->insert([
            'ticket_id' => '1',
            'sequence' => '1',
        ]);
        DB::table('ticket_display_sequences')->insert([
            'ticket_id' => '2',
            'sequence' => '2',
        ]);
    }
}
