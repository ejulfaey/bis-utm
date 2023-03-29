<x-dynamic-component :component="$getFieldWrapperView()" :id="$getId()" :label="$getLabel()" :label-sr-only="$isLabelHidden()" :helper-text="$getHelperText()" :hint="$getHint()" :hint-action="$getHintAction()" :hint-color="$getHintColor()" :hint-icon="$getHintIcon()" :required="$isRequired()" :state-path="$getStatePath()">
    @if($getSrc() !== Storage::url(''))
    <div x-data="{ state: $wire.entangle('{{ $getStatePath() }}').defer, zoomed: false }" @click.away="zoomed = false" @click="zoomed = !zoomed" class="relative bg-gray-800 p-4 flex justify-center rounded-md">
        <img loading="lazy" src="{{ $getSrc() }}" class="w-auto h-72 object-cover">
        <div x-cloak x-show="zoomed" class="p-4 fixed inset-0 bg-gray-900 z-50 flex justify-center items-center">
            <img src="{{ $getSrc() }}" class="w-auto max-h-full object-cover">
        </div>
    </div>
    @else
    <div class="px-4 py-2 text-sm text-gray-600 border border-gray-300 rounded-lg shadow-sm">
        No photo
    </div>
    @endif
</x-dynamic-component>