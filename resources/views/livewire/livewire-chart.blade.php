<div id="{{ $chartId }}"></div>
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    var options = {
        chart: {
            type: 'donut'
        },
        labels: @json($label),
        series: @json($data),
        legend: {
            show: true,
            position: 'bottom',
            height: 50
        }
    };

    var chart = new ApexCharts(document.querySelector("#{{ $chartId }}"), options);
    chart.render();

    Livewire.on('refreshLivewireChart', (charts) => {
        chart.updateOptions({
            labels: charts['chart-1']['label'],
            series: charts['chart-1']['data'],
        });
    });
</script>
@endpush