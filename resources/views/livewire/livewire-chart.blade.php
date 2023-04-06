<div id="{{ $chartId }}"></div>
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    init();

    function init() {
        new ApexCharts(document.querySelector("#{{ $chartId }}"), {
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
        }).render();
    }

    Livewire.on('refreshLivewireChart', (charts) => {
        new ApexCharts(document.querySelector("#{{ $chartId }}"), {
            chart: {
                type: 'donut'
            },
            labels: charts['{{ $chartId }}']['label'],
            series: charts['{{ $chartId }}']['data'],
            legend: {
                show: true,
                position: 'bottom',
                height: 50
            }
        }).render();

        // chart.updateOptions({
        //     labels: charts['chart-1']['label'],
        //     series: charts['chart-1']['data'],
        // });
    });
</script>
@endpush