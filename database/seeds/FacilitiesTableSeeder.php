<?php

use App\Facility;
use Illuminate\Database\Seeder;

class FacilitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $facilities = [
            "Wi-Fi gratuito",
            "Essenziali (asciugamani, lenzuola ecc.)",
            "Parcheggio",
            "Piscina",
            "Sauna",
            "TV",
            "Cucina",
            "Asciugacapelli",
            "Aria condizionata"
        ];


        foreach ($facilities as $facility) {
            $new_facility = new Facility();
            $new_facility->name = $facility;
            $new_facility->save();
        }
    }
}
