<?php

namespace Database\Seeders;

use App\Enums\GenresEnum;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GenreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $genres = GenresEnum::getAllGenres();

        foreach($genres as $genre) {
            DB::table('genres')->insert([
                'name' => $genre
            ]);
        }
    }
}
