@if($overall > 0)
<div class="py-4">
    <div class="p-4 w-full grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        <div class="px-4 py-6 border shadow-sm rounded-lg flex flex-col justify-center items-center">
            <h2 class="text-2xl font-medium">{{ $matrix }}</h2>
            <span class="mt-2 text-sm text-primary-500 font-medium">Overall Total Matrix</span>
        </div>
        <div class="px-4 py-6 border shadow-sm rounded-lg flex flex-col justify-center items-center">
            <h2 class="text-2xl font-medium">{{ $defect }}</h2>
            <span class="mt-2 text-sm text-primary-500 font-medium">Overall Total Defect</span>
        </div>
        <div class="px-4 py-6 bg-primary-500 text-white border shadow-sm rounded-lg flex flex-col justify-center items-center">
            <h2 class="text-2xl font-medium">{{ $overall }}</h2>
            <span class="mt-2 text-sm font-medium">Overall Condition Score</span>
        </div>
    </div>
    <div class="p-4 w-full grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        <div class="px-4 py-6 border shadow-sm rounded-lg flex flex-col justify-center items-center">
            <livewire:livewire-chart chartId="chart-1" :label="$chart1['label']" :data="$chart1['data']" />
        </div>
        <div class="px-4 py-6 border shadow-sm rounded-lg flex flex-col justify-center items-center">
            <livewire:livewire-chart chartId="chart-2" :label="$chart2['label']" :data="$chart2['data']" />
        </div>
        <div class="px-4 py-6 border shadow-sm rounded-lg flex flex-col justify-center items-center">
            <livewire:livewire-chart chartId="chart-3" :label="$chart3['label']" :data="$chart3['data']" />
        </div>
    </div>
</div>
@endif