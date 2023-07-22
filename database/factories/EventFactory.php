<?php

namespace Database\Factories;

use App\Models\Event;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
class EventFactory extends Factory
{
    protected $model = Event::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => $this->faker->word,
            'address' => $this->faker->address,
            'date' => $this->faker->dateTime(),
            'time' => $this->faker->time,
            'description' => $this->faker->sentence,
            'ticketPrice' => $this->faker->numberBetween(10,300)
        ];
    }
}
