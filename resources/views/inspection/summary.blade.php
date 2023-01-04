<div class="px-4 py-8">
    <div class="flex flex-col space-y-4">
        <div class="flex items-center gap-x-4">
            <span class="text-sm text-gray-600">Overall Total Matrix</span>
            <p class="w-32 px-4 py-2 text-right rounded-lg shadow-sm border focus:outline-none">{{ $total_matrix }}</p>
        </div>
        <div class="flex items-center gap-x-4">
            <span class="text-sm text-gray-600">Overall Total Defect</span>
            <p class="w-32 px-4 py-2 text-right rounded-lg shadow-sm border focus:outline-none">{{ $total_defect }}</p>
        </div>
        <div class="flex items-center gap-x-4">
            <span class="text-sm text-gray-600">Overall Condition Score</span>
            <p class="w-32 px-4 py-2 text-right rounded-lg shadow-sm border focus:outline-none">{{ $overall }}</p>
        </div>
    </div>
</div>