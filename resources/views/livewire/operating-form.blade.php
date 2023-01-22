<form wire:submit.prevent="saveOperating">
    {{ $this->form }}
    <x-filament::button type="submit" class="mt-4">
        Save
    </x-filament::button>
</form>