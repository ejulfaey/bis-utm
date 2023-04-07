<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Report;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Rap2hpoutre\FastExcel\FastExcel;
use Illuminate\Support\Str;
use Spatie\Browsershot\Browsershot;

class ReportController extends Controller
{
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
