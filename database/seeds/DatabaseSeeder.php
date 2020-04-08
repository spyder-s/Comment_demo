<?php

use Illuminate\Database\Seeder;
use App\User;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        for ($i = 0; $i <= 10; $i++) {
            $faker = Faker::create();
            $email = $faker->email;
            $user = User::where('email', $email)->first();
            if (empty($user)) {
                $UserData = User::create([
                    'name' => $faker->firstNameFemale . ' ' . $faker->lastName,
                    'email' => $email,
                    'email_verified_at' => $faker->time('H:i:s', '15:00:00'),
                    'password' => Hash::make($email),
                ]);
            }
        }

    }
}
