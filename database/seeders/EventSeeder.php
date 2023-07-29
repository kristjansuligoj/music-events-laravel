<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\Musician;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i = 0; $i < 100; $i++) {
            $event = Event::factory()->create();

            DB::table('events_musicians')->insert([
                'event_id' => $event->id,
                'musician_id' => Musician::inRandomOrder()->first()->id,
            ]);
        }
    }
}
