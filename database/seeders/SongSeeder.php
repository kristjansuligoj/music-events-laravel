<?php

namespace Database\Seeders;

use App\Models\Song;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class SongSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $faker = Faker::create();

        for($i = 0; $i < 100; $i++) {
            $song = Song::factory()->create();

            DB::table('songs_genres')->insert([
                'song_id' => $song->id,
                'genre_id' => rand(1, 7),
            ]);

            DB::table('authors')->insert([
                'song_id' => $song->id,
                'name' => $faker->name
            ]);
        }
    }
}
