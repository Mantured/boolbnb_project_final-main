<?php

use Illuminate\Database\Seeder;
use App\User;
use Faker\Generator as Faker;


class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        $user = new User();
        $user->first_name = 'Claudio';
        $user->last_name = 'bruno';
        $user->email = 'brunocla@gmail.com';
        $user->password = bcrypt('password');
        $user->phone_nr = '333224455';
        $user->date_of_birth = $faker->date();
        $user->save();

        $user = new User();
        $user->first_name = 'Cosmo';
        $user->last_name = 'Ferrigno';
        $user->email = 'cosmo@gmail.com';
        $user->password = bcrypt('password');
        $user->phone_nr = '333224455';
        $user->date_of_birth = $faker->date();
        $user->save();

        for ($i = 0; $i < 10; $i++) {
            $user = new User();
            $user->first_name = $faker->firstName();
            $user->last_name = $faker->lastName();
            $user->email =  $faker->email();
            $user->password = bcrypt('password');
            $user->phone_nr =  $faker->phoneNumber();
            $user->date_of_birth = $faker->date();
            $user->save();
        }
    }
}
