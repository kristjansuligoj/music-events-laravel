<?php

namespace Database\Factories;

use App\Models\Musician;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\File;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Musician>
 */
class MusicianFactory extends Factory
{
    protected $model = Musician::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $defaultImage = rand(1,5) . '.jpeg';
        $destinationImage = time() . '.jpeg';

        // Copy default image to musician-images directory
        $sourcePath = public_path('images/default-musicians/' . $defaultImage);
        $destinationPath = public_path('images/musicians/' . $destinationImage);
        File::copy($sourcePath, $destinationPath);

        return [
            'name' => $this->faker->name(),
            'image' => $destinationImage,
        ];
    }
}
