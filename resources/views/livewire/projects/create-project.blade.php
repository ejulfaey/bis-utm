<x-filament::page>
    <form id="form" class="space-y-4">
        {{ $this->form }}
    </form>
    <div class="flex items-center gap-x-2">
        <a href="/new-projects" class="px-4 py-2 text-sm font-medium">
            Back
        </a>
        <button wire:click="submit" form="form" class="px-4 py-2 text-sm font-medium rounded-lg shadow-sm bg-primary-600 hover:bg-primary-500">
            Save
        </button>
    </div>
</x-filament::page>