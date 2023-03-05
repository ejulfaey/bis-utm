<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Report;
use Illuminate\Http\Request;
use Rap2hpoutre\FastExcel\FastExcel;
use Illuminate\Support\Str;
use Spatie\Browsershot\Browsershot;

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
        return (new FastExcel($reports))->download('REPORTS-' . now()->format('ymdHIs') . '.xlsx', function ($report) {

            return [
                'Date' => $report->created_at->format('M d, Y'),
                'Project' => $report->project->name,
                'Architectural Score' => $report->architectural_score,
                'Architectural Percent' => $report->architectural_percent,
                'Structural Score' => $report->structural_score,
                'Structural Percent' => $report->structural_percent,
                'Building Service Score' => $report->building_score,
                'Building Service Percent' => $report->building_percent,
                'BCA Score' => $report->bca_score,
                'Building Classification' => $report->classification->name,
                'Cost of Maintenance' => $report->maintenance_cost,
                'Time Period' => $report->time_period,
                'NPV For Maintenance' => $report->npv_maintenance,
                'Initial Cost of Construction' => $report->initial_cost,
                'Energy Usage Cost' => $report->energy_usage,
                'Water Usage Cost' => $report->water_usage,
                'Rental Value' => $report->rental_cost,
                'Life Cycle Cost Analysis' => $report->lcca,
                'Summary' => $report->summary,
            ];
        });
    }

    public function summary(Report $report)
    {
        /*
        $html = view('reports.summary', [
            'title' => 'Summary - Report',
            'project' => $report->project,
            'report' => $report,
        ]);
        $filename = Str::random(10) . '.pdf';
        Browsershot::html($html)
            ->margins(10, 10, 10, 10)
            ->format('A4')
            ->save($filename);
        return response()->download($filename);
        */
        return view('reports.summary', [
            'title' => 'Summary - Report',
            'project' => $report->project,
            'report' => $report,
        ]);
    }
}
