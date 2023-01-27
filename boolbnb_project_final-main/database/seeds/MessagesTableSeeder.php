<?php

use Illuminate\Database\Seeder;
use App\Model\Message;
use Faker\Generator as Faker;
use App\Model\Apartment;

class MessagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        $apartment_ids = Apartment::pluck('id')->toArray();
        for ($i=0; $i <30 ; $i++) { 
            $message = new Message();
            $message->apartment_id = $faker->randomElement($apartment_ids);
            $message->content = $faker->text();
            $message->guest_name = $faker->name();
            $message->guest_email = $faker->email();
            $message->save();
        }
    }
}
