<div class="p-4 bg-white">
    <h2 class="text-sm font-bold">Stats</h2>
    <div class="mt-4 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="flex flex-col">
            <p class="text-2xl font-semibold">{{ $projects }}</p>
            <span class="text-sm text-gray-600">Projects</span>
        </div>
        <div class="flex flex-col">
            <p class="text-2xl font-semibold">{{ $inspections }}</p>
            <span class="text-sm text-gray-600">Inspections</span>
        </div>
        <div class="flex flex-col">
            <p class="text-2xl font-semibold">{{ $photos }}</p>
            <span class="text-sm text-gray-600">Photos</span>
        </div>
        <div class="flex flex-col">
            <p class="text-2xl font-semibold">{{ $users }}</p>
            <span class="text-sm text-gray-600">Inspectors</span>
        </div>
    </div>
</div>