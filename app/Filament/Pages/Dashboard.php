<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\OverviewCard;
use Filament\Pages\Page;
use Filament\Widgets\StatsOverviewWidget\Card;

class Dashboard extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-home';

    protected static string $view = 'filament.pages.dashboard';

    protected function getHeaderWidgets(): array
    {
        return [
            // OverviewCard::class,
        ];
    }
}
