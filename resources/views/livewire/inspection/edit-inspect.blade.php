<x-filament::page>
    <form id="form" class="space-y-4">
        {{ $this->form }}
    </form>
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-x-2">
            <a href="/inspection" class="px-4 py-2 text-sm font-medium">
                Back
            </a>
            <button wire:click="submit(0)" class="px-4 py-2 text-sm font-medium rounded-lg shadow-sm bg-primary-500 text-white hover:bg-primary-400">
                Save
            </button>
        </div>
        <div class="flex items-center gap-x-2">
            @if($current_index > 0)
            <button wire:click="rotate(0)" class="flex justify-center items-center gap-x-2 px-4 py-2 text-sm font-medium rounded-lg shadow-sm bg-primary-500 text-white hover:bg-primary-400">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                </svg>
                Prev
            </button>
            @endif
            @if($current_index < count($ids) - 1)
            <button wire:click="rotate(1)" class="flex justify-center items-center gap-x-2 px-4 py-2 text-sm font-medium rounded-lg shadow-sm bg-primary-500 text-white hover:bg-primary-400">
                Next
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                </svg>
            </button>
            @endif
        </div>
    </div>
</x-filament::page>