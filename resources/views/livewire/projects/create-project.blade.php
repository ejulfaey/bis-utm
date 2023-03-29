<x-filament::page>
    <form wire:submit.prevent="submit" class="space-y-4">
        {{ $this->form }}
        <div class="flex items-center gap-x-2">
            <a href="/new-projects" class="px-4 py-2 text-sm font-medium">
                Back
            </a>
            <button class="px-4 py-2 text-sm text-primary-500 font-medium rounded-lg shadow-sm bg-primary-50">Save</button>
            <button wire:click="$set('continue', true)" class="px-4 py-2 text-sm text-white font-medium rounded-lg shadow-sm bg-primary-500 hover:bg-primary-500">Save & Create Another</button>
        </div>
    </form>
</x-filament::page>