<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;

class OverviewCard extends Widget
{
    protected static string $view = 'filament.widgets.overview-card';

    protected function getViewData(): array
    {
        return [
            'text' => 'bola'
        ];
    }
}
