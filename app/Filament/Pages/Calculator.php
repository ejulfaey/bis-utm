<?php

namespace App\Filament\Pages;

use App\Http\Livewire\MaintenanceForm;
use App\Http\Livewire\OperatingForm;
use App\Http\Livewire\RentalForm;
use App\Models\Role;
use Filament\Forms;
use Filament\Pages\Page;

class Calculator extends Page implements Forms\Contracts\HasForms
{
    use Forms\Concerns\InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-calculator';

    protected static ?string $navigationLabel = 'Calculator';

    protected static ?string $title = "Life Cycle Cost Calculator";

    protected static ?string $slug = "calculator";

    protected static string $view = 'filament.pages.calculator';

    protected static ?int $navigationSort = 3;

    public static function shouldRegisterNavigation() : bool
    {
        return in_array(auth()->user()->role_id, [Role::SUPERADMIN, Role::ADMIN]);
    }

    public $activeTab = 'construction';

    public $tabs = [
        'construction' => 'Construction Cost',
        'maintenance' => 'Maintenance Cost',
        'operating' => 'Operating Cost',
        'rental' => 'Rental Cost',
    ];

    public function changeTab($currentTab)
    {
        $this->activeTab = $currentTab;
    }

    protected function getForms(): array
    {
        return [
            'constructionForm' => ConstructionForm::class,
            'maintenanceForm' => MaintenanceForm::class,
            'operatingForm' => OperatingForm::class,
            'rentalForm' => RentalForm::class,
        ];
    }
}
