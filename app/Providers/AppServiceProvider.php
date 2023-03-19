<?php

namespace App\Providers;

use App\Http\Livewire\CalculatorMainTab;
use Illuminate\Support\ServiceProvider;
use Filament\Facades\Filament;
use Filament\Navigation\NavigationGroup;
use Filament\Navigation\NavigationItem;
use Filament\Forms\Components\Field;
use Filament\Forms\Components\Actions\Action;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Field::macro("tooltip", function (\Closure | string | array $tooltip) {
            return $this->hintAction(
                Action::make('help')
                    ->icon('heroicon-o-question-mark-circle')
                    ->extraAttributes(["class" => "text-gray-500"])
                    ->label("")
                    ->tooltip($tooltip)
            );
        });

        Filament::serving(function () {
            Filament::registerViteTheme('resources/css/filament.css');

            Filament::registerNavigationGroups([
                NavigationGroup::make()
                    ->label('Manage'),
                NavigationGroup::make()
                    ->label('Admin Settings')
                    ->collapsed(),
                NavigationGroup::make()
                    ->label('References')
                    ->collapsed(),
            ]);
        });
    }
}
