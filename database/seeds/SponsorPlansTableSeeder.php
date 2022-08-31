<?php

use App\SponsorPlan;
use Illuminate\Database\Seeder;

class SponsorPlansTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $plans = [
            [
                'name' => 'Bronze',
                'price' => 2.99,
                'number_of_hours' => 24
            ],
            [
                'name' => 'Silver',
                'price' => 5.99,
                'number_of_hours' => 72
            ],
            [
                'name' => 'Gold',
                'price' => 9.99,
                'number_of_hours' => 144
            ]
        ];

        foreach ($plans as $plan) {
            $new_plan = new SponsorPlan();
            $new_plan->name = $plan['name'];
            $new_plan->price = $plan['price'];
            $new_plan->number_of_hours = $plan['number_of_hours'];

            $new_plan->save();
        }
    }
}
