<div class="p-2 bg-white">
    <h2 class="p-2 text-sm font-bold">{{ $title }}</h2>
    <div id="{{ $chartId }}"></div>
</div>
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    var options = {
        chart: {
            type: 'bar'
        }
    };

    if ('{{ $type }}' === 'horizontal') {
        options['plotOptions'] = {
            bar: {
                horizontal: true
            }
        };
    }
    options['chart']['stacked'] = true;
    options['labels'] = @json($label);
    options['series'] = [{
        name: 'Marine Sprite',
        data: [44, 55, 41]
    }, {
        name: 'Striking Calf',
        data: [53, 32, 33]
    }, {
        name: 'Tank Picture',
        data: [12, 17, 11]
    }, {
        name: 'Bucket Slope',
        data: [9, 7, 5]
    }, {
        name: 'Reborn Kid',
        data: [25, 12, 19]
    }];
    // options['series'] = [{
    //     data: @json($dataset)
    // }];
    var chart = new ApexCharts(document.querySelector("#{{ $chartId }}"), options);
    chart.render();
</script>
@endpush