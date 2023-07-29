<?php

namespace Database\Factories;

use App\Models\Musician;
use App\Models\Song;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Song>
 */
class SongFactory extends Factory
{
    protected $model = Song::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'musician_id' => Musician::inRandomOrder()->first()->id,
            'title' => $this->faker->words(2, true),
            'length' => $this->faker->numberBetween(10,300),
            'releaseDate' => $this->faker->dateTime(),
        ];
    }
}
