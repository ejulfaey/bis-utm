<?php

namespace App\Filament\Pages;

use App\Http\Livewire\Dashboard\SelectProject;
use App\Models\Inspection;
use App\Models\Parameter;
use App\Models\Role;
use App\Models\User;
use Filament\Forms\Components\Actions\Action;
use Filament\Pages\Page;

class Dashboard extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-home';

    protected static string $view = 'filament.pages.dashboard';

    protected static ?string $slug = 'home';

    protected function getViewData(): array
    {
        $chart = [
            [
                'label' => [],
                'dataset' => [],
            ],
            [
                'label' => [],
                'dataset' => [],
            ],
            [
                'label' => [],
                'dataset' => [],
            ],
        ];

        $start = today();
        $end = today()->subDays(6);

        $days = [];
        $i = 0;
        while ($end->lessThanOrEqualTo($start)) {
            $chart[0]['label'][$i] = $end->format('d/m');
            $chart[0]['dataset'][$i] = Inspection::whereDate('created_at', $end->format('Y-m-d'))->count();

            $end->addDay();
            $i++;
        }

        $i = 0;
        foreach (Parameter::whereGroupId(Parameter::LOCATION)
            ->get()->pluck('name', 'id')->toArray() as $id => $data) {
            $chart[1]['label'][$i] = $data;
            $chart[1]['dataset'][$i] = Inspection::whereLocationId($id)->count();
            $i++;
        };

        $i = 0;
        foreach (User::get()->pluck('name', 'id')->toArray() as $id => $data) {
            $chart[2]['label'][$i] = $data;
            $chart[2]['dataset'][$i] = Inspection::whereUserId($id)->count();
            $i++;
        };

        $i = 0;
        foreach (Parameter::whereGroupId(Parameter::COMPONENT)
            ->get()->pluck('name', 'id')->toArray() as $id => $data) {
            $chart[3]['label'][$i] = $data;
            $chart[3]['dataset'][$i] = Inspection::whereComponentId($id)->count();
            $i++;
        };

        $i = 0;
        foreach (Parameter::whereGroupId(Parameter::SUBCOMPONENT)
            ->get()->pluck('name', 'id')->toArray() as $id => $data) {
            $chart[4]['label'][$i] = $data;
            $chart[4]['dataset'][$i] = Inspection::whereSubComponentId($id)->count();
            $i++;
        };

        return [
            'chart' => $chart,
        ];
    }
}
