<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Report;
use Illuminate\Http\Request;
use Rap2hpoutre\FastExcel\FastExcel;

class ReportController extends Controller
{
    public function project(Request $request)
    {
        $projects = Project::all();
        return (new FastExcel($projects))->download('PROJECTS-' . now()->format('ymdHIs') . '.xlsx');
    }

    public function report(Request $request)
    {
        $reports = Report::all();
        return (new FastExcel($reports))->download('REPORTS-' . now()->format('ymdHIs') . '.xlsx');
    }
}
