<div class="flex flex-col space-y-8">
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
    <div class="px-8 py-4 self-end bg-white border rounded-lg shadow-sm flex items-center gap-x-4">
        <p>Overall Maintenance Cost (RM)</p>
        <h2 class="text-xl font-semibold text-primary-500">{{ number_format(App\Models\MaintenanceCost::sum('total_cost'), 2) }}</h2>
    </div>
</div>