<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Ramsey\Uuid\Uuid;
use Faker\Factory as Faker;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $faker = Faker::create();

        $fakeUsers = [];

        for ($i = 0; $i < 10; $i++) {
            $fakeUsers[] = [
                'name' => $faker->name,
                'email' => $faker->unique()->safeEmail,
            ];
        }

        DB::table('users')->insert([
            'id' => Uuid::uuid4()->toString(),
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('admin12345'),
            'remember_token' => Str::random(10),
        ]);

        DB::table('users')->insert([
            'id' => Uuid::uuid4()->toString(),
            'name' => 'test',
            'email' => 'test@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('test12345'),
            'remember_token' => Str::random(10),
        ]);

        foreach($fakeUsers as $fakeUser) {
            info(json_encode($fakeUser));
            DB::table('users')->insert([
                'id' => Uuid::uuid4()->toString(),
                'name' => $fakeUser['name'],
                'email' => $fakeUser['email'],
                'email_verified_at' => now(),
                'password' => Hash::make('test12345'),
                'remember_token' => Str::random(10),
            ]);
        }
    }
}
