<div class="p-2 bg-white">
    <h2 class="p-2 text-sm font-bold">{{ $title }}</h2>
    <div id="{{ $chartId }}"></div>
</div>
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    var chart = [
        '{{ $chartId }}'
    ];

    chart['{{ $chartId }}'] = new ApexCharts(document.querySelector("#{{ $chartId }}"), {
        chart: {
            type: 'donut'
        },
        labels: @json($label),
        series: @json($dataset),
        legend: {
            show: true,
            position: 'bottom',
            height: 50
        }
    });
    chart['{{ $chartId }}'].render();
</script>
@endpush