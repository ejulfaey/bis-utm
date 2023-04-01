<x-dynamic-component :component="$getFieldWrapperView()" :id="$getId()" :label="$getLabel()" :label-sr-only="$isLabelHidden()" :helper-text="$getHelperText()" :hint="$getHint()" :hint-action="$getHintAction()" :hint-color="$getHintColor()" :hint-icon="$getHintIcon()" :required="$isRequired()" :state-path="$getStatePath()">
    @if($getSrc() !== Storage::url(''))
    <div x-data="{ state: $wire.entangle('{{ $getStatePath() }}').defer, zoomed: false }" @click.away="zoomed = false" @click="zoomed = !zoomed" class="relative">
        <img loading="lazy" src="{{ $getSrc() }}" class="p-6 w-auto h-32 object-cover border border-gray-200 rounded-lg shadow">
        <div x-cloak x-show="zoomed" class="fixed inset-0 bg-gray-200 z-10 flex justify-center items-center" style="padding: 1.5rem;">
            <div class="max-w-4xl w-full">
                <p class="font-medium text-center mb-6">Click anywhere to close</span></p>
                <div class="p-4 bg-white">
                    <img src="{{ $getSrc() }}" alt="zoom-image" class="w-auto h-full">
                </div>
            </div>
        </div>
    </div>
    @else
    <div class="px-4 py-2 text-sm text-gray-600 border border-gray-300 rounded-lg shadow-sm">
        No photo
    </div>
    @endif
</x-dynamic-component>