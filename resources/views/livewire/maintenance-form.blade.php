<div class="space-y-8">
    <form wire:submit.prevent="submit">
        {{ $this->form }}
        <div class="mt-4 flex gap-x-2 justify-end">
            @if($isEdit)
            <x-filament::button wire:click="cancelEdit" type="button" class="bg-primary-100 text-primary-500 hover:bg-primary-200">
                Cancel
            </x-filament::button>
            @endif
            <x-filament::button type="submit">
                Save
            </x-filament::button>
        </div>
    </form>
    {{ $this->table }}
</div>