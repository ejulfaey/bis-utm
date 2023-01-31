<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Rap2hpoutre\FastExcel\FastExcel;

class ReportController extends Controller
{
    public function project(Request $request)
    {
        $projects = Project::all();
        (new FastExcel($projects))->export('PROJECTS_' . now()->format('ymdHIs') . '.xlsx');
    }
}
