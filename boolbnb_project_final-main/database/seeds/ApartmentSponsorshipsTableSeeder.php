<?php

use Illuminate\Database\Seeder;
use App\Model\Apartment;
use App\Model\Sponsorship;
use Carbon\Carbon;
use Faker\Generator as Faker;

class ApartmentSponsorshipsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        // ? recupero tutte le sponsorizzazioni
        //$sponsorships = Sponsorship::all();
            // § recupero gli id di tutti gli appartamenti
            $apartment_ids = Apartment::pluck('id')->toArray();
            $sponsorship_ids = Sponsorship::pluck('id')->toArray();
            $discardedIds = [];

            for ($i=0; $i < 10 ; $i++) { 
                
                $sponsorship = Sponsorship::findOrFail($faker->randomElement($sponsorship_ids));
                $endTime = 0;
                switch ($sponsorship->durations) {
                    case 24:
                        $endTime = 24;
                        break;
                    case 72:
                        $endTime = 72;
                        break;
                    case 144:
                        $endTime = 144;
                        break;
                }
                $theChosenApartment = $faker->randomElement($apartment_ids);
                if(!in_array($theChosenApartment, $discardedIds)){
                    $sponsorship->apartments()->attach($theChosenApartment, [
                        'transaction_code' => $faker->swiftBicNumber(),
                        'starting_time' => Carbon::now(),
                        'ending_time' => Carbon::parse(Carbon::now())->addHours($endTime),
                    ]);
                    array_push($discardedIds, $theChosenApartment);
                }



            }
            
            
        
    }
}
