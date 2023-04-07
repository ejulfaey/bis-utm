<div class="space-y-4">
    <!-- Display list of charts -->
    <div wire:ignore class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-2">
        <x-filament::card>
            <livewire:charts.chart-one :label="$charts['chart-1']['label']" :data="$charts['chart-1']['data']" />
        </x-filament::card>
        <x-filament::card>
            <livewire:charts.chart-two :label="$charts['chart-2']['label']" :data="$charts['chart-2']['data']" />
        </x-filament::card>
        <x-filament::card>
            <livewire:charts.chart-three :label="$charts['chart-3']['label']" :data="$charts['chart-3']['data']" />
        </x-filament::card>
    </div>
    <!-- Display list of tabs for all components -->
    <ul class="flex justify-center gap-x-2">
        <li>
            <button wire:click.prevent="setSelectedTab('all')" class="border px-4 py-2 rounded-md border-gray-200 {{ $selectedTab === 'all' ? 'bg-primary-600 text-white' : 'bg-white text-primary-600' }}">
                All
            </button>
        </li>
        @foreach ($this->tabs as $key => $tab)
        <li>
            <button wire:click.prevent="setSelectedTab('{{ $key }}')" class="border px-4 py-2 rounded-md border-gray-200 {{ $selectedTab == $key ? 'bg-primary-600 text-white' : 'bg-white text-primary-600' }}">
                {{ $tab }}
            </button>
        </li>
        @endforeach
    </ul>
    <!-- Display table for selected component -->
    {{ $this->table }}
</div>