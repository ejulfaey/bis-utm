<x-filament::page>
    <div class="flex justify-end items-center gap-x-2">
        <a href="{{ route('new-projects.create') }}" class="px-4 py-2 bg-primary-600 text-white font-medium text-sm rounded-lg shadow-sm hover:bg-primary-500">
            New Project
        </a>
    </div>
    {{ $this->table }}
</x-filament::page>