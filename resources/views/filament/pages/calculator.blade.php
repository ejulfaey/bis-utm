<x-filament::page>
    <div class="mb-4 border-b border-gray-200 dark:border-gray-700">
        <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="myTab" data-tabs-toggle="#myTabContent" role="tablist">
            @foreach($tabs as $key => $tab)
            <li class="mr-2" role="presentation">
                <button type="button" wire:click="changeTab('{{ $key }}')" @class(["inline-block p-4 border-b-2 rounded-t-lg","text-primary-500 font-medium border-primary-500"=> $activeTab == $key]) role="tab" aria-controls="construction" aria-selected="false">
                    {{ $tab }}
                </button>
            </li>
            @endforeach
        </ul>
    </div>
    <div id="myTabContent">
        <div @class(['hidden'=> $activeTab != 'construction' ]) class="p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="profile" role="tabpanel" aria-labelledby="profile-tab">
            <livewire:construction-form />
        </div>
        <div @class(['hidden'=> $activeTab != 'maintenance' ]) class="p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="dashboard" role="tabpanel" aria-labelledby="dashboard-tab">
            <livewire:maintenance-form />
        </div>
        <div @class(['hidden'=> $activeTab != 'operating' ]) class="p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="settings" role="tabpanel" aria-labelledby="settings-tab">
            <livewire:operating-form />
        </div>
        <div @class(['hidden'=> $activeTab != 'rental' ]) class="p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="contacts" role="tabpanel" aria-labelledby="contacts-tab">
            <livewire:rental-form />
        </div>
    </div>
</x-filament::page>