<?php

namespace Database\Seeders;

use App\Models\Musician;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MusicianSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        for($i = 0; $i < 100; $i++) {
            $musician = Musician::factory()->create();

            DB::table('musicians_genres')->insert([
                'musician_id' => $musician->id,
                'genre_id' => rand(1, 7),
            ]);
        }
    }
}
