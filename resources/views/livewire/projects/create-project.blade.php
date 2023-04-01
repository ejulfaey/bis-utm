<x-filament::page>
    <form wire:submit.prevent="submit" class="space-y-4">
        {{ $this->form }}
        <div class="flex items-center gap-x-2">
            <a href="/new-projects" class="px-4 py-2 text-sm font-medium">
                Back
            </a>
            <x-filament::button type="submit">
                Save
            </x-filament::button>
            <x-filament::button wire:click="$set('continue', true)" type="submit">
                Save & Continue Inspection
            </x-filament::button>
        </div>
    </form>
</x-filament::page>