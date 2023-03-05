<div>
    <select wire:model="project" class="border border-gray-300 rounded-lg text-sm">
        <option value="">Select project</option>
        @forelse($projects as $project)
            <option value="{{ $project->id }}">{{ $project->name }}</option>
        @empty
        @endforelse
    </select>
</div>