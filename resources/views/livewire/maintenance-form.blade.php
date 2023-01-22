<div class="space-y-8">
    <form wire:submit.prevent="submit">
        {{ $this->form }}
        <div class="flex justify-end">
            <x-filament::button type="submit" class="mt-4">
                Save
            </x-filament::button>
        </div>
    </form>
    {{ $this->table }}
</div>