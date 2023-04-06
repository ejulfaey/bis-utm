<div id="chart-3"></div>
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

    var chart3 = new ApexCharts(document.querySelector("#chart-3"), options);
    chart3.render();

    Livewire.on('refreshChartThree', (charts) => {
        chart3.updateOptions({
            labels: charts['label'],
            series: charts['data'],
        });
    });
</script>
@endpush