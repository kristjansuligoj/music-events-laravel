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
            'name' => $this->faker->words(5, true),
            'address' => $this->faker->address,
            'date' => $this->faker->dateTimeBetween('+0 days', '+30 days'),
            'time' => $this->faker->time,
            'description' => $this->faker->sentence,
            'ticketPrice' => $this->faker->numberBetween(10,300)
        ];
    }
}
