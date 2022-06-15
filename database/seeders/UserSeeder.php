<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Faker\Factory;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();

        foreach (range(1,5) as $index ){
            User::create([
                "name" => $faker->name,
                "email" => $faker->unique()->email,
                "password" => Hash::make("123456")
            ]);
        }
    }
}