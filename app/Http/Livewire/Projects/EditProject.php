<?php

namespace App\Http\Livewire\Projects;

use App\Models\Parameter;
use App\Models\Project;
use Livewire\Component;
use Filament\Pages\Page;
use Filament\Forms;
use Livewire\TemporaryUploadedFile;
use Filament\Notifications\Notification;
use Filament\Pages\Actions\Action;

class EditProject extends Page implements Forms\Contracts\HasForms
{

    use Forms\Concerns\InteractsWithForms;


    public Project $project;
    public $user_id;
    public $project_leader;
    public $building_type_id;
    public $college_block;
    public $total_floor;
    public $area_of_building;
    public $plan_attachment;

    protected static string $view = 'livewire.projects.edit-project';

    protected function getBreadcrumbs(): array
    {
        return [
            '/new-projects' => 'Projects',
            route('new-projects.edit', $this->project->id) => 'Edit',
        ];
    }

    public function mount(): void
    {
        $this->form->fill([
            'name' => $this->project->name,
            'user_id' => $this->project->user_id,
            'building_type_id' => $this->project->building_type_id,
            'college_block' => $this->project->college_block,
            'total_floor' => $this->project->total_floor,
            'area_of_building' => $this->project->area_of_building,
            'plan_attachment' => $this->project->plan_attachment,
            'project_leader' => $this->project->user->name,
        ]);
    }

    protected function getFormSchema(): array
    {
        return [
            Forms\Components\Card::make()
                ->schema([
                    Forms\Components\TextInput::make('project.name')
                        ->maxLength(255)
                        ->required(),
                    Forms\Components\TextInput::make('project_leader')
                        ->label('Project Leader')
                        ->disabled(true),
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
                        ->acceptedFileTypes(['application/pdf', 'image/*'])
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
        $this->project->update(
            $this->form->getState(),
        );

        Notification::make()
            ->title('Updated successfully')
            ->icon('heroicon-o-check-circle')
            ->iconColor('success')
            ->send();
    }

    protected function getActions(): array
    {
        return [
            Action::make('delete')
                ->color('danger')
                ->action(fn () => $this->project->delete())
                ->after(fn () => redirect('/new-projects'))
                ->requiresConfirmation(),
        ];
    }
}
