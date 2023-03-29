<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RefreshProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('projects')->truncate();
        DB::table('inspections')->truncate();
        DB::table('inspection_photos')->truncate();
        DB::table('activity_log')
            ->whereIn('subject_type', ['App\Models\Project', 'App\Models\Inspection', 'App\Models\InspectionPhoto'])
            ->delete();
    }
}
