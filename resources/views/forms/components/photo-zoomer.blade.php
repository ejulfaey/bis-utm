<x-dynamic-component :component="$getFieldWrapperView()" :id="$getId()" :label="$getLabel()" :label-sr-only="$isLabelHidden()" :helper-text="$getHelperText()" :hint="$getHint()" :hint-action="$getHintAction()" :hint-color="$getHintColor()" :hint-icon="$getHintIcon()" :required="$isRequired()" :state-path="$getStatePath()">
    <div x-data="{ state: $wire.entangle('{{ $getStatePath() }}').defer, zoomed: false }" @click.away="zoomed = false" @click="zoomed = !zoomed" class="relative bg-gray-800 p-4 flex justify-center rounded-md">
        <img src="{{ env('APP_URL') . '/storage/' . $getSrc() }}" class="w-auto h-72 object-cover">
        <div x-cloak x-show="zoomed" class="fixed inset-0 bg-gray-900 z-50 flex justify-center items-center">
            <img src="{{ env('APP_URL') . '/storage/' . $getSrc() }}" class="p-4 w-full h-auto object-cover">
        </div>
    </div>
</x-dynamic-component>