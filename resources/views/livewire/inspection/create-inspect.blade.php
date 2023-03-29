<x-filament::page>
    <form id="form" class="space-y-4">
        {{ $this->form }}
    </form>
    <div class="flex items-center gap-x-2">
        <a href="/new-projects" class="px-4 py-2 text-sm font-medium">
            Back
        </a>
        <button wire:click="submit(0)" class="px-4 py-2 text-sm font-medium rounded-lg shadow-sm bg-primary-50 text-primary-600 hover:bg-primary-100">
            Save
        </button>
        <button wire:click="submit(1)" class="px-4 py-2 text-sm font-medium rounded-lg shadow-sm bg-primary-500 text-white hover:bg-primary-400">
            Save & Create Another
        </button>
    </div>
</x-filament::page>