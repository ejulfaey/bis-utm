<div class="p-2 bg-white">
    <h2 class="p-2 text-sm font-bold">{{ $title }}</h2>
    <div id="{{ $chartId }}"></div>
</div>
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    var options = {
        chart: {
            type: 'donut'
        }
    };
    options['labels'] = @json($label);
    options['series'] = @json($dataset);
    var chart = new ApexCharts(document.querySelector("#{{ $chartId }}"), options);
    chart.render();
</script>
@endpush