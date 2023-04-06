<div id="chart-1"></div>
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

    var chart1 = new ApexCharts(document.querySelector("#chart-1"), options);
    chart1.render();

    Livewire.on('refreshChartOne', (charts) => {
        chart1.updateOptions({
            labels: charts['label'],
            series: charts['data'],
        });
    });
</script>
@endpush