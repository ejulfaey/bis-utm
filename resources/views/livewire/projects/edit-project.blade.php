<x-filament::page class="space-y-4">
    <form wire:submit.prevent="submit" class="space-y-4">
        {{ $this->form }}
        <div class="flex gap-x-2">
            <a href="/new-projects" class="px-4 py-2 text-sm font-medium">
                Back
            </a>
            <x-filament::button type="submit">
                Save
            </x-filament::button>
        </div>
    </form>
    <livewire:projects.project-tab :project="$project" />
</x-filament::page>