<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="antialiased">
    <div class="container mx-auto space-y-8">
        <div class="flex justify-between">
            <div class="text-sm">
                <h1 class="text-xl font-bold">
                    Summary Report
                </h1>
                <p class="text-gray-600">{{ $project->name }}</p>
                <p class="text-gray-600">{{ $project->user->name }}</p>
            </div>
            <span>25 Jan 2022</span>
        </div>
        <hr />
        <div>
            <h2 class="text-lg text-gray-800 font-semibold">Project Information</h2>
            <table class="mt-4 w-full text-sm text-gray-600">
                <tbody>
                    <tr>
                        <td width="20%" class="border border-gray-400 px-4 py-1.5">Project Name</td>
                        <td class="font-semibold border border-gray-400 px-4 py-1.5">{{ $project->name }}</td>
                    </tr>
                    <tr>
                        <td width="20%" class="border border-gray-400 px-4 py-1.5">Project Leader</td>
                        <td class="font-semibold border border-gray-400 px-4 py-1.5">{{ $project->user->name }}</td>
                    </tr>
                    <tr>
                        <td width="20%" class="border border-gray-400 px-4 py-1.5">Building Type</td>
                        <td class="font-semibold border border-gray-400 px-4 py-1.5">{{ $project->building_type->name }}</td>
                    </tr>
                    <tr>
                        <td width="20%" class="border border-gray-400 px-4 py-1.5">College/Block</td>
                        <td class="font-semibold border border-gray-400 px-4 py-1.5">{{ $project->college_block }}</td>
                    </tr>
                    <tr>
                        <td width="20%" class="border border-gray-400 px-4 py-1.5">Total Floor</td>
                        <td class="font-semibold border border-gray-400 px-4 py-1.5">{{ $project->total_floor }}</td>
                    </tr>
                    <tr>
                        <td width="20%" class="border border-gray-400 px-4 py-1.5">Area of Building</td>
                        <td class="font-semibold border border-gray-400 px-4 py-1.5">{{ $project->area_of_building }}</td>
                    </tr>
                    <tr>
                        <td width="20%" class="border border-gray-400 px-4 py-1.5">Total Inspection</td>
                        <td class="font-semibold border border-gray-400 px-4 py-1.5">{{ $project->inspections->count() }}</td>
                    </tr>
                    <tr>
                        <td width="20%" class="border border-gray-400 px-4 py-1.5">Created At</td>
                        <td class="font-semibold border border-gray-400 px-4 py-1.5">{{ $project->created_at }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div>
            <h2 class="text-lg text-gray-800 font-semibold">Building Condition Assessments</h2>
            <table class="mt-4 w-full text-sm text-gray-600">
                <tbody>
                    <tr>
                        <td width="25%" class="border border-gray-400 px-4 py-1.5">Architectural Score</td>
                        <td width="25%" class="font-semibold border border-gray-400 px-4 py-1.5">{{ $report->architectural_score }}</td>
                        <td width="25%" class="border border-gray-400 px-4 py-1.5">Architectural Percentage</td>
                        <td width="25%" class="font-semibold border border-gray-400 px-4 py-1.5">{{ $report->architectural_percent }}</td>
                    </tr>
                    <tr>
                        <td width="25%" class="border border-gray-400 px-4 py-1.5">Structural Score</td>
                        <td width="25%" class="font-semibold border border-gray-400 px-4 py-1.5">{{ $report->structural_score }}</td>
                        <td width="25%" class="border border-gray-400 px-4 py-1.5">Structural Percentage</td>
                        <td width="25%" class="font-semibold border border-gray-400 px-4 py-1.5">{{ $report->structural_percent }}</td>
                    </tr>
                    <tr>
                        <td width="25%" class="border border-gray-400 px-4 py-1.5">Building Service Score</td>
                        <td width="25%" class="font-semibold border border-gray-400 px-4 py-1.5">{{ $report->building_score }}</td>
                        <td width="25%" class="border border-gray-400 px-4 py-1.5">Building Service Percentage</td>
                        <td width="25%" class="font-semibold border border-gray-400 px-4 py-1.5">{{ $report->building_percent }}</td>
                    </tr>
                    <tr>
                        <td width="25%" class="border border-gray-400 px-4 py-1.5">BCA Score</td>
                        <td width="25%" class="font-semibold border border-gray-400 px-4 py-1.5">{{ $report->bca_score }}</td>
                        <td width="25%" class="border border-gray-400 px-4 py-1.5">Building Classification</td>
                        <td width="25%" class="font-semibold border border-gray-400 px-4 py-1.5">{{ $report->classification->name }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div>
            <h2 class="text-lg text-gray-800 font-semibold">Life Cycle Cost Analysis</h2>
            <table class="mt-4 w-full text-sm text-gray-600">
                <tbody>
                    <tr>
                        <td width="20%" class="border border-gray-400 px-4 py-1.5">Cost of Maintenance</td>
                        <td class="font-semibold border border-gray-400 px-4 py-1.5">RM {{ $report->maintenance_cost }}</td>
                    </tr>
                    <tr>
                        <td width="20%" class="border border-gray-400 px-4 py-1.5">Time Period</td>
                        <td class="font-semibold border border-gray-400 px-4 py-1.5">{{ number_format($report->time_period, 0) }} years</td>
                    </tr>
                    <tr>
                        <td width="20%" class="border border-gray-400 px-4 py-1.5">Discount Rate</td>
                        <td class="font-semibold border border-gray-400 px-4 py-1.5">{{ $report->discount_rate }}%</td>
                    </tr>
                    <tr>
                        <td width="20%" class="border border-gray-400 px-4 py-1.5">NPV of maintenance cost</td>
                        <td class="font-semibold border border-gray-400 px-4 py-1.5">RM {{ number_format($report->npv_maintenance, 2) }}</td>
                    </tr>
                    <tr>
                        <td width="20%" class="border border-gray-400 px-4 py-1.5">Initial Cost of Construction</td>
                        <td class="font-semibold border border-gray-400 px-4 py-1.5">RM {{ number_format($report->initial_cost, 2) }}</td>
                    </tr>
                    <tr>
                        <td width="20%" class="border border-gray-400 px-4 py-1.5">Energy Usage Cost</td>
                        <td class="font-semibold border border-gray-400 px-4 py-1.5">RM {{ number_format($report->energy_usage, 2) }}</td>
                    </tr>
                    <tr>
                        <td width="20%" class="border border-gray-400 px-4 py-1.5">Water Usage Cost</td>
                        <td class="font-semibold border border-gray-400 px-4 py-1.5">RM {{ number_format($report->water_usage, 2) }}</td>
                    </tr>
                    <tr>
                        <td width="20%" class="border border-gray-400 px-4 py-1.5">Rental Value</td>
                        <td class="font-semibold border border-gray-400 px-4 py-1.5">RM {{ number_format($report->rental_cost, 2) }}</td>
                    </tr>
                    <tr>
                        <td width="20%" class="border border-gray-400 px-4 py-1.5">Life Cycle Cost Analysis</td>
                        <td class="font-semibold border border-gray-400 px-4 py-1.5">RM {{ number_format($report->lcca, 2) }}</td>
                    </tr>
                    <tr>
                        <td width="20%" class="border border-gray-400 px-4 py-1.5">Summary</td>
                        <td class="font-semibold border border-gray-400 px-4 py-1.5">{{ $report->summary }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <script>
        window.print();
    </script>

</body>

</html>