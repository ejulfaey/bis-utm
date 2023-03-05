<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Module2Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('construction_costs')->insert([
            [
                'building_type_id' => 23,
            ],
            [
                'building_type_id' => 24,
            ],
            [
                'building_type_id' => 25,
            ],
        ]);

        DB::table('calculators')->insert([
            [
                'e_energy_of_consumption' => 0,
                'e_duration_of_consumption' => 0,
                'e_tariff' => 0,
                'w_usage_of_water' => 0,
                'w_no_of_occupants' => 0,
                'w_tariff' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        DB::table('rental_costs')->insert([
            [
                'cost_room' => 10,
                'no_of_room' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
