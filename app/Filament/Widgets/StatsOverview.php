<?php

namespace App\Filament\Widgets;

use App\Models\Inspection;
use App\Models\Project;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;

class StatsOverview extends BaseWidget
{
    protected function getCards(): array
    {
        return [
            Card::make('Total Projects', Project::count()),
            Card::make('Total Inspections', Inspection::count(),),
        ];
    }
}
