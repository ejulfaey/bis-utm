<?php

namespace App\Filament\Pages;

use App\Http\Livewire\Dashboard\SelectProject;
use Filament\Forms\Components\Actions\Action;
use Filament\Pages\Page;

class Dashboard extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-home';

    protected static string $view = 'filament.pages.dashboard';

    protected static ?string $slug = 'home';
}
