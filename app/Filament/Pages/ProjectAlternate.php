<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use App\Filament\Pages\Project;

class ProjectAlternate extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.project-alternate';

    protected static ?string $navigationLabel = 'Manage Projects';

    protected static bool $shouldRegisterNavigation = false;

    protected function getHeaderWidgets(): array
    {
        return [
            Project\ListProject::class,
        ];
    }

    
}
