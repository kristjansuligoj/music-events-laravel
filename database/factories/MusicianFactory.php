<?php

namespace Database\Factories;

use App\Models\Musician;
use App\Models\User;
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
        $user = User::inRandomOrder()->first();

        $defaultImage = rand(1,5) . '.jpeg';
        $destinationImage = time() . '.jpeg';

        // Copy default image to musician-images directory
        $sourcePath = public_path('images/default-musicians/' . $defaultImage);
        $destinationPath = public_path('images/musicians/' . $destinationImage);

        $path = public_path('images/musicians/');
        File::isDirectory($path) or File::makeDirectory($path, 0777, true, true);

        File::copy($sourcePath, $destinationPath);

        return [
            'name' => $this->faker->name(),
            'image' => $destinationImage,
            'user_id' => $user->id,
        ];
    }
}
