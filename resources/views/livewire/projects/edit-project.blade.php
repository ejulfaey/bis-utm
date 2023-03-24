<x-filament::page>
    <form wire:submit.prevent="submit" class="space-y-4">
        {{ $this->form }}

    </form>
    <a href="/new-projects" class="px-4 py-2 text-sm font-medium">
        Back
    </a>
    <x-filament::button type="submit" class="bg-primary-600 hover:bg-primary-500">
        Save
    </x-filament::button>
</x-filament::page>