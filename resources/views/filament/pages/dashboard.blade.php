<div class="space-y-6">
    <div class="flex justify-between items-center">
        <h1 class="text-2xl font-bold">Dashboard</h1>
        <div class="flex gap-x-2">
            <livewire:dashboard.select-project />
            <livewire:dashboard.select-date />
        </div>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3">
        <livewire:dashboard.bar-chart chartId="chart-1" :label="['Jan', 'Feb', 'Mac']" :dataset="[5, 6, 7]" />
        <livewire:dashboard.bar-chart type="horizontal" chartId="chart-2" :label="['Jan', 'Feb', 'Mac']" :dataset="[1, 2, 7]" />
        <livewire:dashboard.bar-chart type="horizontal" chartId="chart-3" :label="['Jan', 'Feb', 'Mac']" :dataset="[1, 2, 7]" />
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5">
        <livewire:dashboard.bar-chart chartId="chart-4" :label="['Jan', 'Feb', 'Mac']" :dataset="[5, 6, 7]" />
        <livewire:dashboard.bar-chart type="horizontal" chartId="chart-5" :label="['Jan', 'Feb', 'Mac']" :dataset="[1, 2, 7]" />
        <livewire:dashboard.bar-chart type="horizontal" chartId="chart-6" :label="['Jan', 'Feb', 'Mac']" :dataset="[1, 2, 7]" />
        <livewire:dashboard.bar-chart type="horizontal" chartId="chart-7" :label="['Jan', 'Feb', 'Mac']" :dataset="[1, 2, 7]" />
        <livewire:dashboard.bar-chart type="horizontal" chartId="chart-8" :label="['Jan', 'Feb', 'Mac']" :dataset="[1, 2, 7]" />
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3">
        <livewire:dashboard.bar-chart chartId="chart-9" :label="['Jan', 'Feb', 'Mac']" :dataset="[5, 6, 7]" />
        <livewire:dashboard.bar-chart type="horizontal" chartId="chart-10" :label="['Jan', 'Feb', 'Mac']" :dataset="[1, 2, 7]" />
        <livewire:dashboard.bar-chart type="horizontal" chartId="chart-11" :label="['Jan', 'Feb', 'Mac']" :dataset="[1, 2, 7]" />
    </div>
</div>