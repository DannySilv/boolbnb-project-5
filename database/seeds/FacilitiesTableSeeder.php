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
            "Free Wi-Fi",
            "Essentials (towels, bed sheets etc.)",
            "Car Parking",
            "Swimming Pool",
            "Sauna",
            "TV",
            "Kitchen",
            "Hair Dryer",
            "Air Conditioner"
        ];


        foreach ($facilities as $facility) {
            $new_facility = new Facility();
            $new_facility->name = $facility;
            $new_facility->save();
        }
    }
}
