<div id="{{ $chartId }}"></div>
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    console.log(@json($data), @json($label));
    var options = {
        chart: {
            type: 'donut'
        },
        labels: @json($label),
        series: @json($data),
    };

    var chart = new ApexCharts(document.querySelector("#{{ $chartId }}"), options);

    chart.render();
</script>
@endpush