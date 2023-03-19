<x-dynamic-component :component="$getFieldWrapperView()" :id="$getId()" :label="$getLabel()" :label-sr-only="$isLabelHidden()" :helper-text="$getHelperText()" :hint="$getHint()" :hint-action="$getHintAction()" :hint-color="$getHintColor()" :hint-icon="$getHintIcon()" :required="$isRequired()" :state-path="$getStatePath()">
    <div x-data="{ state: $wire.entangle('{{ $getStatePath() }}').defer }">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @forelse($getOptions() as $photo)
            <div class="p-1.5 border border-gray-300 rounded-md shadow">
                <img src="{{ env('APP_URL') . '/storage/' . $photo['photo'] }}" alt="photo">
            </div>
            @empty
            <p class="text-gray-600">No photo added</p>
            @endforelse
        </div>
    </div>
</x-dynamic-component>