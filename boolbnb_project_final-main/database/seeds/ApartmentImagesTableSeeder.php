<?php

use App\Model\Apartment;
use App\Model\Apartment_image;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class ApartmentImagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        $house_img = config('hause');
        $apartment_ids = Apartment::pluck('id')->toArray();
        foreach ($apartment_ids as $apartment) {
            $max = rand(1, 6);
            for ($i = 0; $i < $max; $i++) {
                $newImage = new Apartment_image();
                $newImage->apartment_id = $apartment;
                $newImage->image_path = $faker->randomElement($house_img);
                $newImage->save();
            }
        }
    }
}
