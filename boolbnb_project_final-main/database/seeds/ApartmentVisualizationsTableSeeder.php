<?php

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use App\Model\Apartment;
use App\Model\Apartment_visualization;

class ApartmentVisualizationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        $apartment_ids = Apartment::pluck('id')->toArray();

        for ($i = 0; $i < 10; $i++) {
            $newVisualization = new Apartment_visualization();
            $newVisualization->apartment_id = $faker->randomElement($apartment_ids);
            $newVisualization->visualization_date = $faker->dateTime();
            $newVisualization->ip_address = $faker->localIpv4();
            $newVisualization->save();
        }
    }
}
