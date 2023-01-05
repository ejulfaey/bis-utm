<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;

class StatsOverview extends BaseWidget
{
    protected function getCards(): array
    {
        return [
            Card::make('Overall Total Matrix', '1'),
            Card::make('Overall Total Matrix', '1'),
            Card::make('Overall Total Matrix', '1'),
        ];
    }
}
