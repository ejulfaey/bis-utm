<?php

namespace App\Http\Livewire\Inspection;

use App\Models\Inspection;
use App\Models\InspectionPhoto;
use App\Models\Parameter;
use App\Models\Project;
use Filament\Forms;
use Filament\Notifications\Notification;
use Livewire\Component;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Storage;

class EditInspect extends Page implements Forms\Contracts\HasForms
{
    use Forms\Concerns\InteractsWithForms;

    public Inspection $inspect;
    public Project $project;
    public $total_matrix;
    public $ids;
    public $current_index;
    public $photos = [];

    protected static ?string $navigationLabel = 'Edit Inspection';

    protected static string $view = 'livewire.inspection.edit-inspect';

    protected function getBreadcrumbs(): array
    {
        return [
            '/inspection' => 'Inspection',
            route('inspection.edit', $this->inspect) => 'Edit',
        ];
    }

    public function mount()
    {
        $this->ids = Inspection::whereProjectId($this->inspect->project_id)
            ->pluck('id')
            ->toArray();
        $this->current_index = array_search($this->inspect->id, $this->ids);
        $this->project = $this->inspect->project->load('user');
        $this->total_matrix = $this->inspect->total_matrix;
        $this->photos = $this->inspect->photos->pluck('photo', 'id')->toArray();
    }

    protected function getFormSchema(): array
    {
        return [
            Forms\Components\Section::make('Project Info')
                ->description('Project description')
                ->schema([
                    Forms\Components\TextInput::make('project.name')
                        ->label('Project')
                        ->disabled(true)
                        ->columnSpanFull('true'),
                    Forms\Components\TextInput::make('project.user.name')
                        ->label('Project Leader')
                        ->disabled(true),
                    Forms\Components\TextInput::make('project.college_block')
                        ->label('College/Block')
                        ->disabled(true),
                    Forms\Components\TextInput::make('project.total_floor')
                        ->disabled(true),
                    /*
                    PhotoZoomer::make('project.plan_attachment')
                        ->label('Drawing Plan')
                        ->src($this->project->plan_attachment ?? '')
                        ->columnSpanFull(true)
                        */
                ])
                ->columns(3)
                ->collapsible(),
            Forms\Components\Section::make('BCA Inventory')
                ->description('Component')
                ->schema([
                    Forms\Components\Grid::make(3)
                        ->schema([
                            Forms\Components\DatePicker::make('inspect.date')
                                ->maxDate(today()->addDay())
                                ->default(today())
                                ->required(),
                            Forms\Components\Select::make('inspect.weather_id')
                                ->label('Weather')
                                ->options(Parameter::active()->whereGroupId(Parameter::WEATHER)->pluck('name', 'id'))
                                ->required(),
                            Forms\Components\TextInput::make('inspect.floor_no')
                                ->label('Floor No.')
                                ->required()
                                ->maxLength(255),
                            Forms\Components\TextInput::make('inspect.unit_no')
                                ->label('Unit No.')
                                ->required()
                                ->maxLength(255),
                            Forms\Components\TextInput::make('inspect.grid_no')
                                ->label('Grid No.')
                                ->maxLength(255),
                            Forms\Components\Select::make('inspect.location_id')
                                ->label('Location')
                                ->options(Parameter::active()->whereGroupId(Parameter::LOCATION)->pluck('name', 'id'))
                                ->searchable()
                                ->required(),
                        ]),
                    Forms\Components\Grid::make(3)
                        ->schema([
                            Forms\Components\Select::make('inspect.component_id')
                                ->label('Component')
                                ->options(Parameter::active()->whereGroupId(Parameter::COMPONENT)->pluck('name', 'id'))
                                ->reactive()
                                ->required(),
                            Forms\Components\Select::make('inspect.sub_component_id')
                                ->label('Sub Component')
                                ->searchable()
                                ->options(function (callable $get) {
                                    if ($get('inspect.component_id')) {
                                        return Parameter::whereParentId($get('inspect.component_id'))->pluck('name', 'id');
                                    }
                                })
                                ->required(),
                            Forms\Components\Select::make('inspect.defect_id')
                                ->label('Building Defect')
                                ->options(Parameter::active()->whereGroupId(Parameter::DEFECT)->pluck('name', 'id'))
                                ->searchable()
                                ->required(),
                        ]),
                    Forms\Components\Grid::make(2)
                        ->schema([
                            Forms\Components\Select::make('inspect.condition_score_id')
                                ->label('Condition Score')
                                ->tooltip(function () {
                                    $scores = Parameter::whereGroupId(Parameter::SCORE_CONDITION)->pluck('name', 'value');
                                    $str = '';
                                    foreach ($scores as $key => $value) {
                                        $str .= $key . ' - ' . $value . ', ';
                                    }
                                    $str = rtrim($str, ', ');
                                    return $str;
                                })
                                ->options(Parameter::active()->whereGroupId(Parameter::SCORE_CONDITION)->pluck('value', 'id'))
                                ->afterStateUpdated(fn ($state) => $this->onChangeResult($state))
                                ->reactive()
                                ->required(),
                            Forms\Components\Select::make('inspect.maintenance_score_id')
                                ->label('Maintenance Score')
                                ->tooltip(function () {
                                    $scores = Parameter::whereGroupId(Parameter::SCORE_MAINTENANCE)->pluck('name', 'value');
                                    $str = '';
                                    foreach ($scores as $key => $value) {
                                        $str .= $key . ' - ' . $value . ', ';
                                    }
                                    $str = rtrim($str, ', ');
                                    return $str;
                                })
                                ->options(Parameter::active()->whereGroupId(Parameter::SCORE_MAINTENANCE)->pluck('value', 'id'))
                                ->afterStateUpdated(fn ($state) => $this->onChangeResult($state))
                                ->reactive()
                                ->required(),
                        ]),
                    Forms\Components\TextInput::make('total_matrix')
                        ->disabled(true),
                    Forms\Components\Select::make('inspect.classification_id')
                        ->label('Classification')
                        ->disabled(true)
                        ->options(Parameter::active()->whereGroupId(Parameter::CLASSIFICATION)->pluck('name', 'id')),
                    Forms\Components\Textarea::make('inspect.remark')
                        ->columnSpan('full')
                        ->maxLength(1000),
                    Forms\Components\FileUpload::make('photos')
                        ->directory('photos')
                        ->image()
                        ->multiple()
                        ->maxSize(10240)
                        ->helperText('Maximum size is 10MB')
                        ->columnSpan('full'),
                ])->columns([
                    'sm' => 1,
                    'md' => 2,
                ])

        ];
    }

    public function onChangeProject($id)
    {
        $this->project = Project::with('user')->find($id);
    }

    public function onChangeResult()
    {
        if ($this->inspect->condition_score_id && $this->inspect->maintenance_score_id) {
            $ids = Parameter::select('id', 'value')
                ->whereIn('id', [$this->inspect->condition_score_id, $this->inspect->maintenance_score_id])
                ->get()
                ->toArray();
            $this->total_matrix = array_product(data_get($ids, '*.value'));
            $this->inspect->classification_id = Parameter::active()->whereGroupId(Parameter::CLASSIFICATION)->whereRaw('? between `from` and `to`', $this->total_matrix)
                ->first()
                ->id;
        }
    }

    // $type = 1, next, $type = 0, prev
    public function rotate($type)
    {
        if ($type) {
            $id = $this->ids[$this->current_index + 1];
        } else {
            $id = $this->ids[$this->current_index - 1];
        }
        return redirect()->route('inspection.edit', Inspection::find($id));
    }

    public function submit($other)
    {
        $data = $this->form->getState();
        $oriPhotos = $this->inspect->photos->pluck('photo', 'id')->toArray();
        $toDelete = array_diff($oriPhotos, $data['photos']);

        if (!empty($toDelete)) {
            foreach ($toDelete as $id => $fileName) {
                if (Storage::exists($fileName)) Storage::delete($fileName);
                InspectionPhoto::find($id)->delete();
            }
        }
        foreach ($data['photos'] as $fileName) {
            if (!in_array($fileName, $oriPhotos)) {
                InspectionPhoto::create([
                    'inspection_id' => $this->inspect->id,
                    'photo' => $fileName,
                ]);
            }
        }
        $data = $data['inspect'];

        $this->inspect->update(
            $data
        );

        Notification::make()
            ->title('Updated successfully')
            ->icon('heroicon-o-check-circle')
            ->iconColor('success')
            ->send();
    }
}
