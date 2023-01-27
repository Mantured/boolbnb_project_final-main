<?php

use Illuminate\Database\Seeder;
use App\Model\Service;
use App\Model\Apartment;
use Faker\Generator as Faker;


class ServicesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        /* popolazione dei servizi */
        $services_name = config('facility');
        foreach($services_name as $service){
            $newService = new Service();
            $newService->name = strtolower($service);
            $newService->save();
        }

        /* associazione dei servizi agli appartamenti */
        $service_ids = Service::pluck('id')->toArray();

        // § Prendo tutti gli id disponibili in categories
        $apartments = Apartment::all();

        foreach ($apartments as $apartment) {
            $apartment->services()->sync($faker->randomElements($service_ids, rand(1,count($services_name))));
        }
    }
}
