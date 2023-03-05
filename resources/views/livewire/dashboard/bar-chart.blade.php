<div class="bg-white p-2 border border-gray-300 rounded-lg">
    <div id="{{ $chartId }}"></div>
</div>
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    var options = {};

    if ('{{ $type }}' === 'horizontal') {
        options = {
            chart: {
                type: 'bar',
                stacked: true
            },
            plotOptions: {
                bar: {
                    horizontal: true
                }
            },
            labels: @json($label),
            series: [{
                data: @json($dataset)
            }],
        }
    } else {
        options = {
            chart: {
                type: 'bar'
            },
            labels: @json($label),
            series: [{
                data: @json($dataset)
            }],
        }
    }
    var chart = new ApexCharts(document.querySelector("#{{ $chartId }}"), options);
    chart.render();
</script>
@endpush