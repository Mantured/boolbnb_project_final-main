<?php

use App\Model\Sponsorship;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UsersTableSeeder::class,
            ApartmentsTableSeeder::class,
            ApartmentImagesTableSeeder::class,
            MessagesTableSeeder::class,
            ServicesTableSeeder::class,
            SponsorshipsTableSeeder::class,
            //ApartmentSponsorshipsTableSeeder::class,
            //ApartmentVisualizationsTableSeeder::class,
        ]);
    }
}
