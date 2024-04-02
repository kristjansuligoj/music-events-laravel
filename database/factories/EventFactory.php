<?php

namespace Database\Factories;

use App\Models\Event;
use App\Models\User;
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
        $user = User::inRandomOrder()->first();

        return [
            'name' => $this->faker->words(5, true),
            'address' => str_replace(["\n", "\r"], '', $this->faker->address),
            'date' => $this->faker->dateTimeBetween('+0 days', '+30 days'),
            'time' => $this->faker->time("H:m"),
            'description' => $this->faker->sentence,
            'ticketPrice' => $this->faker->numberBetween(10,300),
            'user_id' => $user->id,
        ];
    }
}
