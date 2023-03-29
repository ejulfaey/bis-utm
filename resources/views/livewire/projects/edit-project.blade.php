<x-filament::page>
    <form wire:submit.prevent="submit" class="space-y-4">
        {{ $this->form }}
    </form>
    <a href="/new-projects" class="px-4 py-2 text-sm font-medium">
        Back
    </a>
    <button wire:click="submit" class="px-4 py-2 text-sm font-medium rounded-lg shadow-sm bg-primary-500 text-white hover:bg-primary-400">
        Save
    </button>
</x-filament::page>