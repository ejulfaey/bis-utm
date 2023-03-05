<div class="space-y-6">
    <div class="flex justify-between items-center">
        <h1 class="text-2xl font-bold">Dashboard</h1>
        <div class="flex gap-x-2">
            <livewire:dashboard.select-project />
            <livewire:dashboard.select-date />
        </div>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        <livewire:dashboard.bar-chart chartId="chart-1" :label="['Jan', 'Feb', 'Mac']" :dataset="[5, 6, 7]" />
        <livewire:dashboard.bar-chart type="horizontal" chartId="chart-2" :label="['Jan', 'Feb', 'Mac']" :dataset="[1, 2, 7]" />
        <div class="w-full h-32 bg-gray-300 rounded"></div>
    </div>
</div>