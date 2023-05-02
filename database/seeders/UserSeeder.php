<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Faker\Generator as Faker;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        $user = User::create([
            'name' => 'Bernardo Greco',
            'email' => 'Bernardo.greco98@gmail.com',
            'password' => Hash::make('ciccio12'),
        ]);

        for ($i = 0; $i < 10; $i++) {

            User::create([
                'name' => $faker->name(),
                'email' => $faker->unique()->email(),
                'password' => Hash::make($faker->word()),
            ]);
        }
    }
}
