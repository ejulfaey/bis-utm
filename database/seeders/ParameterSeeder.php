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
            ['id' => 1, 'group_id' => 1, 'name' => 'Sunny', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'group_id' => 1, 'name' => 'Rainy', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 3, 'group_id' => 1, 'name' => 'Cloudy', 'created_at' => now(), 'updated_at' => now()],

            // location
            ['id' => 4, 'group_id' => 2, 'name' => 'Location A', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 5, 'group_id' => 2, 'name' => 'Location B', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 6, 'group_id' => 2, 'name' => 'Location C', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 7, 'group_id' => 2, 'name' => 'Location D', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 8, 'group_id' => 2, 'name' => 'Location E', 'created_at' => now(), 'updated_at' => now()],

            // component
            ['id' => 9, 'group_id' => 3, 'name' => 'Component A', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 10, 'group_id' => 3, 'name' => 'Component B', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 11, 'group_id' => 3, 'name' => 'Component C', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 12, 'group_id' => 3, 'name' => 'Component D', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 13, 'group_id' => 3, 'name' => 'Component E', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 14, 'group_id' => 3, 'name' => 'Component F', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 15, 'group_id' => 3, 'name' => 'Component G', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 16, 'group_id' => 3, 'name' => 'Component H', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 17, 'group_id' => 3, 'name' => 'Component I', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 18, 'group_id' => 3, 'name' => 'Component J', 'created_at' => now(), 'updated_at' => now()],

            // sub-component
            ['id' => 19, 'group_id' => 4, 'name' => 'Sub Component A', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 20, 'group_id' => 4, 'name' => 'Sub Component B', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 21, 'group_id' => 4, 'name' => 'Sub Component C', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 22, 'group_id' => 4, 'name' => 'Sub Component D', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 23, 'group_id' => 4, 'name' => 'Sub Component E', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 24, 'group_id' => 4, 'name' => 'Sub Component F', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 25, 'group_id' => 4, 'name' => 'Sub Component G', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 26, 'group_id' => 4, 'name' => 'Sub Component H', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 27, 'group_id' => 4, 'name' => 'Sub Component I', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 28, 'group_id' => 4, 'name' => 'Sub Component J', 'created_at' => now(), 'updated_at' => now()],

            // defects
            ['id' => 29, 'group_id' => 5, 'name' => 'Defect A', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 30, 'group_id' => 5, 'name' => 'Defect B', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 31, 'group_id' => 5, 'name' => 'Defect C', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 32, 'group_id' => 5, 'name' => 'Defect D', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 33, 'group_id' => 5, 'name' => 'Defect E', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 34, 'group_id' => 5, 'name' => 'Defect A', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 35, 'group_id' => 5, 'name' => 'Defect B', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 36, 'group_id' => 5, 'name' => 'Defect C', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 37, 'group_id' => 5, 'name' => 'Defect D', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 38, 'group_id' => 5, 'name' => 'Defect E', 'created_at' => now(), 'updated_at' => now()],

            // classfication
            ['id' => 39, 'group_id' => 6, 'name' => 'Defect C', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 40, 'group_id' => 6, 'name' => 'Defect D', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 41, 'group_id' => 6, 'name' => 'Defect E', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 42, 'group_id' => 6, 'name' => 'Defect A', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 43, 'group_id' => 6, 'name' => 'Defect B', 'created_at' => now(), 'updated_at' => now()],

        ]);

        DB::table('parameters')->insert([
            //     // Condition Score
            ['id' => 44, 'group_id' => 7, 'name' => 'Bad', 'value' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 45, 'group_id' => 7, 'name' => 'Poor', 'value' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 46, 'group_id' => 7, 'name' => 'Moderate', 'value' => 3, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 47, 'group_id' => 7, 'name' => 'Good', 'value' => 4, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 48, 'group_id' => 7, 'name' => 'Best', 'value' => 5, 'created_at' => now(), 'updated_at' => now()],
            // Maintenance Score
            ['id' => 49, 'group_id' => 8, 'name' => 'Bad', 'value' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 50, 'group_id' => 8, 'name' => 'Poor', 'value' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 51, 'group_id' => 8, 'name' => 'Moderate', 'value' => 3, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 52, 'group_id' => 8, 'name' => 'Good', 'value' => 4, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 53, 'group_id' => 8, 'name' => 'Best', 'value' => 5, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
