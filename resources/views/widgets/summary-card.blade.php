@if($overall > 0)
<div class="py-4">
    <div class="p-4 w-full grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        <div class="px-4 py-6 border shadow-sm rounded-lg flex flex-col justify-center items-center">
            <h2 class="text-2xl font-medium">{{ $matrix }}</h2>
            <span class="mt-2 text-sm text-primary-500 font-medium">Overall Total Matrix</span>
        </div>
        <div class="px-4 py-6 border shadow-sm rounded-lg flex flex-col justify-center items-center">
            <h2 class="text-2xl font-medium">{{ $defect }}</h2>
            <span class="mt-2 text-sm text-primary-500 font-medium">Overall Total Defect</span>
        </div>
        <div class="px-4 py-6 bg-primary-500 text-white border shadow-sm rounded-lg flex flex-col justify-center items-center">
            <h2 class="text-2xl font-medium">{{ $overall }}</h2>
            <span class="mt-2 text-sm font-medium">Overall Condition Score</span>
        </div>
    </div>
    <div class="p-4 w-full grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        <div class="px-4 py-6 border shadow-sm rounded-lg flex flex-col justify-center items-center">
            <canvas id="chart1"></canvas>
        </div>
        <div class="px-4 py-6 border shadow-sm rounded-lg flex flex-col justify-center items-center">
            <canvas id="chart2"></canvas>
        </div>
        <div class="px-4 py-6 border shadow-sm rounded-lg flex flex-col justify-center items-center">
            <canvas id="chart3"></canvas>
        </div>
    </div>
</div>
@endif
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx1 = document.getElementById('chart1');
    new Chart(ctx1, {
        type: 'doughnut',
        data: {
            labels: @json($chart1['label']),
            datasets: [{
                label: '# of Defects',
                data: @json($chart1['data']),
                borderWidth: 3
            }]
        },
    });

    const ctx2 = document.getElementById('chart2');
    new Chart(ctx2, {
        type: 'doughnut',
        data: {
            labels: @json($chart2['label']),
            datasets: [{
                label: '# of Defects',
                data: @json($chart2['data']),
                borderWidth: 3
            }]
        },
    });

    const ctx3 = document.getElementById('chart3');
    new Chart(ctx3, {
        type: 'doughnut',
        data: {
            labels: @json($chart3['label']),
            datasets: [{
                label: '# of Defects',
                data: @json($chart3['data']),
                borderWidth: 3
            }]
        },
    });
</script>
@endpush