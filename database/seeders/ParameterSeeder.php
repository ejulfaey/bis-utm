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
            ['group_id' => 2, 'name' => 'Hall', 'created_at' => now(), 'updated_at' => now()],
            ['group_id' => 2, 'name' => 'Room', 'created_at' => now(), 'updated_at' => now()],
            ['group_id' => 2, 'name' => 'Bathroom/Toilet', 'created_at' => now(), 'updated_at' => now()],
            ['group_id' => 2, 'name' => 'External Area', 'created_at' => now(), 'updated_at' => now()],
            ['group_id' => 2, 'name' => 'Corridor', 'created_at' => now(), 'updated_at' => now()],

            // defects
            ['group_id' => 5, 'name' => 'Corrosion', 'created_at' => now(), 'updated_at' => now()],
            ['group_id' => 5, 'name' => 'Cracking', 'created_at' => now(), 'updated_at' => now()],
            ['group_id' => 5, 'name' => 'Spalling', 'created_at' => now(), 'updated_at' => now()],
            ['group_id' => 5, 'name' => 'Deflection', 'created_at' => now(), 'updated_at' => now()],
            ['group_id' => 5, 'name' => 'Delamination', 'created_at' => now(), 'updated_at' => now()],
            ['group_id' => 5, 'name' => 'Peeling paint', 'created_at' => now(), 'updated_at' => now()],
            ['group_id' => 5, 'name' => 'Mold and fungus', 'created_at' => now(), 'updated_at' => now()],
            ['group_id' => 5, 'name' => 'Dampness', 'created_at' => now(), 'updated_at' => now()],
            ['group_id' => 5, 'name' => 'Discolouration', 'created_at' => now(), 'updated_at' => now()],
            ['group_id' => 5, 'name' => 'Missing', 'created_at' => now(), 'updated_at' => now()],
            ['group_id' => 5, 'name' => 'Malfunction', 'created_at' => now(), 'updated_at' => now()],
            ['group_id' => 5, 'name' => 'Broken', 'created_at' => now(), 'updated_at' => now()],
            ['group_id' => 5, 'name' => 'Leaking', 'created_at' => now(), 'updated_at' => now()],
            ['group_id' => 5, 'name' => 'Rot/Rusting', 'created_at' => now(), 'updated_at' => now()],

            // building type
            ['group_id' => 7, 'name' => 'Reinforced Concrete - Low-rise building', 'created_at' => now(), 'updated_at' => now()],
            ['group_id' => 7, 'name' => 'Reinforced Concrete - Mid-rise building', 'created_at' => now(), 'updated_at' => now()],
            ['group_id' => 7, 'name' => 'Reinforced Concrete - High-rise building', 'created_at' => now(), 'updated_at' => now()],

            ['group_id' => 11, 'name' => 'Single Room', 'created_at' => now(), 'updated_at' => now()],
            ['group_id' => 11, 'name' => 'Double Room', 'created_at' => now(), 'updated_at' => now()],
            ['group_id' => 11, 'name' => 'Twin Room', 'created_at' => now(), 'updated_at' => now()],
            ['group_id' => 11, 'name' => 'Master Room', 'created_at' => now(), 'updated_at' => now()],
        ]);

        DB::table('parameters')->insert([
            // sub-component
            ['group_id' => 4, 'name' => 'Beam', 'parent_id' => 54, 'created_at' => now(), 'updated_at' => now()],
            ['group_id' => 4, 'name' => 'Column', 'parent_id' => 54, 'created_at' => now(), 'updated_at' => now()],
            ['group_id' => 4, 'name' => 'Slab', 'parent_id' => 54, 'created_at' => now(), 'updated_at' => now()],
            ['group_id' => 4, 'name' => 'Staircase', 'parent_id' => 54, 'created_at' => now(), 'updated_at' => now()],
            ['group_id' => 4, 'name' => 'Roofing system', 'parent_id' => 54, 'created_at' => now(), 'updated_at' => now()],
            ['group_id' => 4, 'name' => 'Wall', 'parent_id' => 54, 'created_at' => now(), 'updated_at' => now()],
            ['group_id' => 4, 'name' => 'Foundation', 'parent_id' => 54, 'created_at' => now(), 'updated_at' => now()],

            ['group_id' => 4, 'name' => 'Building finishes-(Beam)', 'parent_id' => 55, 'created_at' => now(), 'updated_at' => now()],
            ['group_id' => 4, 'name' => 'Building finishes-(Column)', 'parent_id' => 55, 'created_at' => now(), 'updated_at' => now()],
            ['group_id' => 4, 'name' => 'Building finishes-(Slab)', 'parent_id' => 55, 'created_at' => now(), 'updated_at' => now()],
            ['group_id' => 4, 'name' => 'Building finishes-(Wall)', 'parent_id' => 55, 'created_at' => now(), 'updated_at' => now()],
            ['group_id' => 4, 'name' => 'Building finishes-(Foundation)', 'parent_id' => 55, 'created_at' => now(), 'updated_at' => now()],
            ['group_id' => 4, 'name' => 'Building finishes-(Staircase)', 'parent_id' => 55, 'created_at' => now(), 'updated_at' => now()],
            ['group_id' => 4, 'name' => 'Door and frame', 'parent_id' => 55, 'created_at' => now(), 'updated_at' => now()],
            ['group_id' => 4, 'name' => 'Window and frame', 'parent_id' => 55, 'created_at' => now(), 'updated_at' => now()],
            ['group_id' => 4, 'name' => 'Ceiling', 'parent_id' => 55, 'created_at' => now(), 'updated_at' => now()],

            ['group_id' => 4, 'name' => 'Hose reel', 'parent_id' => 56, 'created_at' => now(), 'updated_at' => now()],
            ['group_id' => 4, 'name' => 'Fire extinguisher system', 'parent_id' => 56, 'created_at' => now(), 'updated_at' => now()],
            ['group_id' => 4, 'name' => 'Fire alarm system', 'parent_id' => 56, 'created_at' => now(), 'updated_at' => now()],
            ['group_id' => 4, 'name' => 'Socket/Switch', 'parent_id' => 56, 'created_at' => now(), 'updated_at' => now()],
            ['group_id' => 4, 'name' => 'Electrical cable', 'parent_id' => 56, 'created_at' => now(), 'updated_at' => now()],
            ['group_id' => 4, 'name' => 'Distribution board', 'parent_id' => 56, 'created_at' => now(), 'updated_at' => now()],
            ['group_id' => 4, 'name' => 'Lift', 'parent_id' => 56, 'created_at' => now(), 'updated_at' => now()],
            ['group_id' => 4, 'name' => 'Plumbing system', 'parent_id' => 56, 'created_at' => now(), 'updated_at' => now()],

        ]);

        DB::table('parameters')->insert([
            // component
            ['group_id' => 3, 'name' => 'Structural', 'value' => '22.22', 'created_at' => now(), 'updated_at' => now()],
            ['group_id' => 3, 'name' => 'Architectural', 'value' => '66.67', 'created_at' => now(), 'updated_at' => now()],
            ['group_id' => 3, 'name' => 'Building Service', 'value' => '11.11', 'created_at' => now(), 'updated_at' => now()],
            // Condition Score
            ['group_id' => 8, 'name' => 'Very Severe', 'value' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['group_id' => 8, 'name' => 'Severe', 'value' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['group_id' => 8, 'name' => 'Moderate', 'value' => 3, 'created_at' => now(), 'updated_at' => now()],
            ['group_id' => 8, 'name' => 'Negligible', 'value' => 4, 'created_at' => now(), 'updated_at' => now()],
            // Maintenance Score
            ['group_id' => 9, 'name' => 'Replacement/Emergency', 'value' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['group_id' => 9, 'name' => 'Repart/Urgent', 'value' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['group_id' => 9, 'name' => 'Routine', 'value' => 3, 'created_at' => now(), 'updated_at' => now()],
            ['group_id' => 9, 'name' => 'Normal', 'value' => 4, 'created_at' => now(), 'updated_at' => now()],
        ]);

        DB::table('parameters')->insert([
            // Classification
            ['group_id' => 6, 'name' => 'Class 1 - Very Severe', 'from' => 1, 'to' => 4, 'created_at' => now(), 'updated_at' => now()],
            ['group_id' => 6, 'name' => 'Class 2 - Severe', 'from' => 5, 'to' => 8, 'created_at' => now(), 'updated_at' => now()],
            ['group_id' => 6, 'name' => 'Class 3 - Moderate', 'from' => 9, 'to' => 12, 'created_at' => now(), 'updated_at' => now()],
            ['group_id' => 6, 'name' => 'Class 4 - Negligible', 'from' => 13, 'to' => 16, 'created_at' => now(), 'updated_at' => now()],

            // Classification Building
            ['group_id' => 10, 'name' => 'Bad', 'from' => 0, 'to' => 70, 'created_at' => now(), 'updated_at' => now()],
            ['group_id' => 10, 'name' => 'Moderate', 'from' => 71, 'to' => 80, 'created_at' => now(), 'updated_at' => now()],
            ['group_id' => 10, 'name' => 'Good', 'from' => 81, 'to' => 100, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
