<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\Musician;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        for($i = 0; $i < 100; $i++) {
            $event = Event::factory()->create();

            DB::table('events_musicians')->insert([
                'event_id' => $event->id,
                'musician_id' => Musician::inRandomOrder()->first()->id,
            ]);

            // Range [-25, 7] makes sure that there is less of a chance that there are 7 attendees of an event
            $participantCount = rand(-25, 7);

            if ($participantCount < 0) {
                $participantCount = 0;
            }

            $userIds = User::inRandomOrder()->limit($participantCount)->pluck('id')->toArray();

            foreach($userIds as $userId) {
                DB::table('event_participants')->insert([
                    'event_id' => $event->id,
                    'user_id' => $userId,
                ]);
            }
        }
    }
}
