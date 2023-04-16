<x-dynamic-component :component="$getFieldWrapperView()" :id="$getId()" :label="$getLabel()" :label-sr-only="$isLabelHidden()" :helper-text="$getHelperText()" :hint="$getHint()" :hint-action="$getHintAction()" :hint-color="$getHintColor()" :hint-icon="$getHintIcon()" :required="$isRequired()" :state-path="$getStatePath()">
    @if($getSrc() !== Storage::url(''))
    <div x-data="{ state: $wire.entangle('{{ $getStatePath() }}').defer, zoomed: false }" @click.away="zoomed = false" @click="zoomed = !zoomed" class="relative w-full border p-4 flex justify-center rounded-lg shadow">
        <img loading="lazy" src="{{ $getSrc() }}" class="rounded" style="height: 32rem">
        <div x-cloak x-show="zoomed" class="fixed inset-0 bg-gray-100 z-10 flex justify-center items-center">
            <div class="h-screen">
                <p class="p-4 font-medium text-center">Click anywhere to close</span></p>
                <img src="{{ $getSrc() }}" alt="zoom-image" class="object-contain h-full">
            </div>
        </div>
    </div>
    @else
    <div class="px-4 py-2 text-sm text-gray-600 border border-gray-300 rounded-lg shadow-sm">
        No photo
    </div>
    @endif
</x-dynamic-component>