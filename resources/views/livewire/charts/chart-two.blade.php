<div id="chart-2"></div>
@push('scripts')
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

    var chart2 = new ApexCharts(document.querySelector("#chart-2"), options);
    chart2.render();

    Livewire.on('refreshChartTwo', (charts) => {
        chart2.updateOptions({
            labels: charts['label'],
            series: charts['data'],
        });
    });
</script>
@endpush