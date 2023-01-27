<?php

use Illuminate\Database\Seeder;
use App\Model\Sponsorship;

class SponsorshipsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sponsoships = [
            [
                'name' => 'silver',
                'price' => 2.99,
                'durations' => 24
            ],
            [
                'name' => 'golden',
                'price' => 5.99,
                'durations' => 72
            ],
            [
                'name' => 'platinum',
                'price' => 9.99,
                'durations' => 144
            ]
        ];
        foreach ($sponsoships as $sponsorship) {
            $newSponsorship = new Sponsorship();
            $newSponsorship->name = $sponsorship['name'];
            $newSponsorship->price = $sponsorship['price'];
            $newSponsorship->durations = $sponsorship['durations'];
            $newSponsorship->save();
        }

        /* importiamo tutte le sponsirizzazioni */
        /* $sponsorships = Sponsorship::all(); */
        /* creo un array che contiene gli id degli appartamenti */
        /*  $apartment_ids = Apartment::pluck('id')->toArray(); */




        /* foreach ($apartment_ as $apartment) {
            $apartment->services()->sync($faker->randomElements($service_ids, rand(1,count($services_name))));
        } */
    }
}
