<x-filament::page>
    <form wire:submit.prevent="submit" class="space-y-4">
        {{ $this->form }}
        <div class="flex gap-x-2">
            <a href="/new-projects" class="px-4 py-2 text-sm font-medium">
                Back
            </a>
            <x-filament::button>
                Save
            </x-filament::button>
        </div>
    </form>
</x-filament::page>