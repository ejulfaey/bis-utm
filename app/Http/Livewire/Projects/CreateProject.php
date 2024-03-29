<?php

namespace App\Http\Livewire\Projects;

use App\Models\Parameter;
use App\Models\Project;
use Filament\Forms;
use Filament\Pages\Page;
use Livewire\TemporaryUploadedFile;
use Filament\Notifications\Notification;

class CreateProject extends Page implements Forms\Contracts\HasForms
{
    use Forms\Concerns\InteractsWithForms;

    public $name;
    public $user_id;
    public $building_type_id;
    public $college_block;
    public $total_floor;
    public $area_of_building;
    public $plan_attachment;
    public $continue = false;

    protected static string $view = 'livewire.projects.create-project';

    protected function getBreadcrumbs(): array
    {
        return [
            '/new-projects' => 'Projects',
            route('new-projects.create') => 'Create',
        ];
    }

    protected function getFormSchema(): array
    {
        return [
            Forms\Components\Card::make()
                ->schema([
                    Forms\Components\TextInput::make('name')
                        ->maxLength(255)
                        ->required()
                        ->columnSpanFull(),
                    Forms\Components\Grid::make(2)
                        ->schema([
                            Forms\Components\Select::make('building_type_id')
                                ->label('Building Type')
                                ->options(Parameter::whereGroupId(Parameter::BUILDING_TYPE)->pluck('name', 'id'))
                                ->required(),
                            Forms\Components\TextInput::make('college_block')
                                ->label('College/Block')
                                ->required()
                                ->maxLength(255),
                            Forms\Components\TextInput::make('total_floor')
                                ->numeric()
                                ->required(),
                            Forms\Components\TextInput::make('area_of_building')
                                ->label('Area of Building (m2)')
                                ->numeric()
                                ->required(),
                        ]),
                    Forms\Components\FileUpload::make('plan_attachment')
                        ->label('Drawing Plan')
                        ->directory('plans')
                        ->image()
                        ->maxSize(10240)
                        ->getUploadedFileNameForStorageUsing(function (TemporaryUploadedFile $file): string {
                            return (string) str(date('dmyhis') . '.' . $file->extension())->prepend('plan-');
                        })
                        ->helperText('Maximum size is 10MB')
                        ->columnSpan('full'),
                ])
                ->columns([
                    'sm' => 1,
                    'md' => 2,
                ])
        ];
    }

    public function submit()
    {
        $data = array_merge($this->form->getState(), ['user_id' => auth()->id()]);
        $project = Project::create($data);

        Notification::make()
            ->title('Saved successfully')
            ->icon('heroicon-o-check-circle')
            ->iconColor('success')
            ->send();

        return $this->continue ? redirect()->route('inspection.create', ['project' => $project->id]) : redirect()->route('new-projects.edit', $project->id);
    }
}
