<div>
    <div class="flex flex-col md:flex-row justify-between md:items-center">
        <h1 class="text-2xl font-bold">Dashboard</h1>
        {{-- <div class="mt-2 md:mt-0 flex gap-x-2">
            <livewire:dashboard.select-project />
            <livewire:dashboard.select-date />
        </div> --}}
    </div>
    <div class="mt-4 md:mt-6 space-y-4">
        <livewire:dashboard.stats />
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            <livewire:dashboard.bar-chart title="Daily Inspections" chartId="chart-1" :label="$chart[0]['label']" :dataset="$chart[0]['dataset']" />
            <livewire:dashboard.bar-chart title="Location" chartId="chart-2" :label="$chart[1]['label']" :dataset="$chart[1]['dataset']" />
            <livewire:dashboard.donut-chart title="Inspectors" chartId="chart-3" :label="$chart[2]['label']" :dataset="$chart[2]['dataset']" />
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <livewire:dashboard.donut-chart title="Components" chartId="chart-4" :label="$chart[3]['label']" :dataset="$chart[3]['dataset']" />
            <livewire:dashboard.donut-chart title="Sub Components" chartId="chart-5" :label="$chart[4]['label']" :dataset="$chart[4]['dataset']" />
        </div>
    </div>
</div>