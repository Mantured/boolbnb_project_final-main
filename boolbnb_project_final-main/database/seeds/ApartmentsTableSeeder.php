<?php

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use App\Model\Apartment;
use App\User;
use Illuminate\Support\Str;

class ApartmentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {

        $addressArray =[
            [
                'address' => 'Via di Santo Stefano in Pane, 20, 50134 Firenze FI',
                'lat' => '43.8128',
                'log' => '11.251',
            ],
            [
                'address' => "Via dell'Oche, 16R, 50122 Firenze FI",
                'lat' => '43.8127319',
                'log' => '11.251007',
            ],
            [
                'address' => "Piazza del Duomo, Milano MI, Italia",
                'lat' => '45.4640658',
                'log' => '9.1906621',
            ],
            [
                'address' => "P.za del Duomo, 8, 20123 Milano MI",
                'lat' => '45.4632648',
                'log' => '9.1904073',
            ],
            [
                'address' => "Piazza dei Mercanti, 20123 Milano MI",
                'lat' => '45.4646599',
                'log' => '9.1876261',
            ],
            [
                'address' => "Via Filippo Corridoni, 103, 56125 Pisa PI",
                'lat' => '43.7078222',
                'log' => '10.4018876',
            ],
            [
                'address' => "P.le Luciano Lischi, 28, 56126 Pisa PI",
                'lat' => '43.7085',
                'log' => '10.4036',
            ],
            [
                'address' => "Via Bonanno Pisano, 43, 56126 Pisa PI",
                'lat' => '43.7178457',
                'log' => '10.3889097',
            ],
            [
                'address' => "Via Balbi, 38A, 16126 Genova GE, Italia",
                'lat' => '44.416319',
                'log' => '8.9234677',
            ],
            [
                'address' => "Via della Maddalena, 32/2, 16124 Genova GE",
                'lat' => '44.4104801',
                'log' => '8.9319611',
            ],
            [
                'address' => "Via Pionieri e Aviatori d'Italia, 44, 16154 Genova GE ",
                'lat' => '44.4168772',
                'log' => '8.8536501',
            ],
            [
                'address' => "Corso Cavour, 184, 70121 Bari BA",
                'lat' => '41.1188919',
                'log' => '16.872904',
            ],
            [
                'address' => "Strada Statale 16 Km 786 950 Giovinazzo, 70054 Bari BA",
                'lat' => '41.185',
                'log' => '16.6705',
            ],
            [
                'address' => "28, strada provinciale bitonto aeroporto palese n, 70132 Bari BA",
                'lat' => '41.11148',
                'log' => '16.8554',
            ],
            [
                'address' => "Via Luca Samuele Cagnazzi, 29, 80136 Napoli NA",
                'lat' => '40.8615503',
                'log' => '14.2490604',
            ],
            [
                'address' => "Via Francesco del Giudice, 13, 80138 Napoli NA",
                'lat' => '40.8517593',
                'log' => '14.2538755',
            ],
            [
                'address' => "Via S. Felice, 26, 40122 Bologna BO",
                'lat' => '44.4966822',
                'log' => '11.33417',
            ],
            [
                'address' => "Via Villanova, 29/8, 40055 Bologna BO",
                'lat' => '44.4905932',
                'log' => '11.4177316',
            ],
            [
                'address' => "Via Saliceto, 8, 40010 Bentivoglio BO",
                'lat' => '44.5869338',
                'log' => '11.3894478',
            ],
            [
                'address' => "dell'Isola, Via Lungomare, 86861 Tropea VV",
                'lat' => '38.67449',
                'log' => '15.89505',
            ],
        ];


        $user_ids = User::pluck('id')->toArray();
        for ($i = 0; $i < 20; $i++) {

            $apartment = new Apartment();
            $apartment->user_id = $faker->randomElement($user_ids);
            $apartment->title = $faker->sentence(3);
            $apartment->slug = Str::slug($apartment->title, '-') . "-$i";
            /* $apartment->description = $faker->text(); */
            $apartment->description = $faker->paragraphs(7, true);
            $apartment->rooms_number = rand(1, 5);
            $apartment->bathrooms_number = rand(1, 3);
            $apartment->beds_number = rand(1, 8);
            $apartment->square_meters = rand(50, 200);
            $random = $faker->unique()->randomElement($addressArray);
            $apartment->address = $random['address'];
            $apartment->latitude = $random['lat'];
            $apartment->longitude = $random['log'];
            $apartment->price_per_night = $faker->randomFloat(2, 20, 99999);
            $apartment->save();
        }
    }
}
