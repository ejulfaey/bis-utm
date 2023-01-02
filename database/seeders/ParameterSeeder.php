<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ParameterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('parameters')->insert([
            // Weather
            ['group_id' => 1, 'name' => 'Sunny', 'created_at' => now(), 'updated_at' => now()],
            ['group_id' => 1, 'name' => 'Rainy', 'created_at' => now(), 'updated_at' => now()],
            ['group_id' => 1, 'name' => 'Cloudy', 'created_at' => now(), 'updated_at' => now()],

            // location
            ['group_id' => 2, 'name' => 'Location A', 'created_at' => now(), 'updated_at' => now()],
            ['group_id' => 2, 'name' => 'Location B', 'created_at' => now(), 'updated_at' => now()],
            ['group_id' => 2, 'name' => 'Location C', 'created_at' => now(), 'updated_at' => now()],
            ['group_id' => 2, 'name' => 'Location D', 'created_at' => now(), 'updated_at' => now()],
            ['group_id' => 2, 'name' => 'Location E', 'created_at' => now(), 'updated_at' => now()],

            // component
            ['group_id' => 3, 'name' => 'Structural', 'created_at' => now(), 'updated_at' => now()],
            ['group_id' => 3, 'name' => 'Architectural', 'created_at' => now(), 'updated_at' => now()],
            ['group_id' => 3, 'name' => 'Building Service', 'created_at' => now(), 'updated_at' => now()],

            // sub-component
            ['group_id' => 4, 'name' => 'Sub Component A', 'created_at' => now(), 'updated_at' => now()],
            ['group_id' => 4, 'name' => 'Sub Component B', 'created_at' => now(), 'updated_at' => now()],
            ['group_id' => 4, 'name' => 'Sub Component C', 'created_at' => now(), 'updated_at' => now()],
            ['group_id' => 4, 'name' => 'Sub Component D', 'created_at' => now(), 'updated_at' => now()],
            ['group_id' => 4, 'name' => 'Sub Component E', 'created_at' => now(), 'updated_at' => now()],
            ['group_id' => 4, 'name' => 'Sub Component F', 'created_at' => now(), 'updated_at' => now()],
            ['group_id' => 4, 'name' => 'Sub Component G', 'created_at' => now(), 'updated_at' => now()],
            ['group_id' => 4, 'name' => 'Sub Component H', 'created_at' => now(), 'updated_at' => now()],
            ['group_id' => 4, 'name' => 'Sub Component I', 'created_at' => now(), 'updated_at' => now()],
            ['group_id' => 4, 'name' => 'Sub Component J', 'created_at' => now(), 'updated_at' => now()],

            // defects
            ['group_id' => 5, 'name' => 'Defect A', 'created_at' => now(), 'updated_at' => now()],
            ['group_id' => 5, 'name' => 'Defect B', 'created_at' => now(), 'updated_at' => now()],
            ['group_id' => 5, 'name' => 'Defect C', 'created_at' => now(), 'updated_at' => now()],
            ['group_id' => 5, 'name' => 'Defect D', 'created_at' => now(), 'updated_at' => now()],
            ['group_id' => 5, 'name' => 'Defect E', 'created_at' => now(), 'updated_at' => now()],
            ['group_id' => 5, 'name' => 'Defect A', 'created_at' => now(), 'updated_at' => now()],
            ['group_id' => 5, 'name' => 'Defect B', 'created_at' => now(), 'updated_at' => now()],
            ['group_id' => 5, 'name' => 'Defect C', 'created_at' => now(), 'updated_at' => now()],
            ['group_id' => 5, 'name' => 'Defect D', 'created_at' => now(), 'updated_at' => now()],
            ['group_id' => 5, 'name' => 'Defect E', 'created_at' => now(), 'updated_at' => now()],

            // classfication
            ['group_id' => 6, 'name' => 'Great', 'created_at' => now(), 'updated_at' => now()],
            ['group_id' => 6, 'name' => 'Good', 'created_at' => now(), 'updated_at' => now()],
            ['group_id' => 6, 'name' => 'Moderate', 'created_at' => now(), 'updated_at' => now()],
            ['group_id' => 6, 'name' => 'Bad', 'created_at' => now(), 'updated_at' => now()],
            ['group_id' => 6, 'name' => 'Poor', 'created_at' => now(), 'updated_at' => now()],

            // building type
            ['group_id' => 7, 'name' => 'Building Type A', 'created_at' => now(), 'updated_at' => now()],
            ['group_id' => 7, 'name' => 'Building Type B', 'created_at' => now(), 'updated_at' => now()],
            ['group_id' => 7, 'name' => 'Building Type C', 'created_at' => now(), 'updated_at' => now()],
            ['group_id' => 7, 'name' => 'Building Type D', 'created_at' => now(), 'updated_at' => now()],

        ]);

        DB::table('parameters')->insert([
            //     // Condition Score
            ['group_id' => 8, 'name' => 'Bad', 'value' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['group_id' => 8, 'name' => 'Poor', 'value' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['group_id' => 8, 'name' => 'Moderate', 'value' => 3, 'created_at' => now(), 'updated_at' => now()],
            ['group_id' => 8, 'name' => 'Good', 'value' => 4, 'created_at' => now(), 'updated_at' => now()],
            ['group_id' => 8, 'name' => 'Best', 'value' => 5, 'created_at' => now(), 'updated_at' => now()],
            // Maintenance Score
            ['group_id' => 9, 'name' => 'Bad', 'value' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['group_id' => 9, 'name' => 'Poor', 'value' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['group_id' => 9, 'name' => 'Moderate', 'value' => 3, 'created_at' => now(), 'updated_at' => now()],
            ['group_id' => 9, 'name' => 'Good', 'value' => 4, 'created_at' => now(), 'updated_at' => now()],
            ['group_id' => 9, 'name' => 'Best', 'value' => 5, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
