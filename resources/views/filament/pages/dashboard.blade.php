<div>
    <div class="flex flex-col md:flex-row justify-between md:items-center">
        <h1 class="text-2xl font-bold">Dashboard</h1>
        <div class="mt-2 md:mt-0 flex gap-x-2">
            <livewire:dashboard.select-project />
            <livewire:dashboard.select-date />
        </div>
    </div>
    <div class="mt-4 md:mt-6 space-y-2">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-2 ">
            <livewire:dashboard.bar-chart title="Time Period" chartId="chart-1" :label="['Jan', 'Feb', 'Mac']" :dataset="[5, 6, 7]" />
            <livewire:dashboard.donut-chart title="Inspections" chartId="chart-2" :label="['Jan', 'Feb', 'Mac']" :dataset="[1, 2, 7]" />
            <livewire:dashboard.stats />
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-2">
            <livewire:dashboard.bar-chart title="Project" type="horizontal" chartId="chart-5" :label="['Jan', 'Feb', 'Mac']" :dataset="[1, 2, 7]" />
            <livewire:dashboard.bar-chart title="Phase" type="horizontal" chartId="chart-6" :label="['Jan', 'Feb', 'Mac', 'Apr', 'May', 'Jun']" :dataset="[1, 2, 7, 3, 4, 12]" />
            <livewire:dashboard.bar-chart title="Location" type="horizontal" chartId="chart-7" :label="['Jan', 'Feb', 'Mac']" :dataset="[1, 2, 7]" />
            <livewire:dashboard.bar-chart title="Responsible Party" type="horizontal" chartId="chart-8" :label="['Jan', 'Feb', 'Mac']" :dataset="[1, 2, 7]" />
            <livewire:dashboard.bar-chart title="Inspector" type="horizontal" chartId="chart-4" :label="['Jan', 'Feb', 'Mac']" :dataset="[1, 2, 7]" />
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-2">
            <livewire:dashboard.bar-chart title="Checklists" chartId="chart-9" :label="['Jan', 'Feb', 'Mac']" :dataset="[5, 6, 7]" />
            <livewire:dashboard.bar-chart title="Inspector Type" type="horizontal" chartId="chart-10" :label="['Jan', 'Feb', 'Mac']" :dataset="[1, 2, 7]" />
            <livewire:dashboard.bar-chart title="Status" type="horizontal" chartId="chart-11" :label="['Jan', 'Feb', 'Mac']" :dataset="[1, 2, 7]" />
        </div>
    </div>
</div>