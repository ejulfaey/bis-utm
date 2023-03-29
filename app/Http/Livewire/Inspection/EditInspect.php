<?php

namespace App\Http\Livewire\Inspection;

use App\Models\Inspection;
use App\Models\Parameter;
use App\Models\Project;
use Filament\Forms;
use Filament\Notifications\Notification;
use Livewire\Component;
use Filament\Pages\Page;

class EditInspect extends Page implements Forms\Contracts\HasForms
{
    use Forms\Concerns\InteractsWithForms;

    protected static ?string $navigationLabel = 'Edit Inspection';

    protected static string $view = 'livewire.inspection.edit-inspect';

    public Inspection $inspect;
    public Project $project;
    public $project_id;
    public $date;
    public $weather_id;
    public $floor_no;
    public $user_id;
    public $unit_no;
    public $grid_no;
    public $component_id;
    public $sub_component_id;
    public $defect_id;
    public $location_id;
    public $condition_score_id;
    public $maintenance_score_id;
    public $total_matrix;
    public $classification_id;
    public $remark;
    public $ids;
    public $current_index;

    public function mount()
    {
        $this->ids = Inspection::whereProjectId($this->inspect->project_id)
            ->pluck('id')
            ->toArray();
        $this->current_index = array_search($this->inspect->id, $this->ids);

        $this->form->fill([
            'project' => $this->inspect->project,
            'project_id' => $this->inspect->project_id,
            'date' => $this->inspect->date,
            'weather_id' => $this->inspect->weather_id,
            'floor_no' => $this->inspect->floor_no,
            'user_id' => $this->inspect->user_id,
            'unit_no' => $this->inspect->unit_no,
            'grid_no' => $this->inspect->grid_no,
            'component_id' => $this->inspect->component_id,
            'sub_component_id' => $this->inspect->sub_component_id,
            'defect_id' => $this->inspect->defect_id,
            'location_id' => $this->inspect->location_id,
            'condition_score_id' => $this->inspect->condition_score_id,
            'maintenance_score_id' => $this->inspect->maintenance_score_id,
            'total_matrix' => $this->inspect->total_matrix,
            'classification_id' => $this->inspect->classification_id,
            'remark' => $this->inspect->remark,
        ]);
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
                            Forms\Components\DatePicker::make('date')
                                ->maxDate(today()->addDay())
                                ->default(today())
                                ->required(),
                            Forms\Components\Select::make('weather_id')
                                ->label('Weather')
                                ->options(Parameter::active()->whereGroupId(Parameter::WEATHER)->pluck('name', 'id'))
                                ->required(),
                            Forms\Components\TextInput::make('floor_no')
                                ->label('Floor No.')
                                ->required()
                                ->maxLength(255),
                            Forms\Components\TextInput::make('unit_no')
                                ->label('Unit No.')
                                ->required()
                                ->maxLength(255),
                            Forms\Components\TextInput::make('grid_no')
                                ->label('Grid No.')
                                ->maxLength(255),
                            Forms\Components\Select::make('location_id')
                                ->label('Location')
                                ->options(Parameter::active()->whereGroupId(Parameter::LOCATION)->pluck('name', 'id'))
                                ->searchable()
                                ->required(),
                        ]),
                    Forms\Components\Grid::make(3)
                        ->schema([
                            Forms\Components\Select::make('component_id')
                                ->label('Component')
                                ->options(Parameter::active()->whereGroupId(Parameter::COMPONENT)->pluck('name', 'id'))
                                ->reactive()
                                ->required(),
                            Forms\Components\Select::make('sub_component_id')
                                ->label('Sub Component')
                                ->searchable()
                                ->options(function (callable $get) {
                                    if ($get('component_id')) {
                                        return Parameter::whereParentId($get('component_id'))->pluck('name', 'id');
                                    }
                                })
                                ->required(),
                            Forms\Components\Select::make('defect_id')
                                ->label('Building Defect')
                                ->options(Parameter::active()->whereGroupId(Parameter::DEFECT)->pluck('name', 'id'))
                                ->searchable()
                                ->required(),
                        ]),
                    Forms\Components\Grid::make(2)
                        ->schema([
                            Forms\Components\Select::make('condition_score_id')
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
                            Forms\Components\Select::make('maintenance_score_id')
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
                    Forms\Components\Select::make('classification_id')
                        ->label('Classification')
                        ->disabled(true)
                        ->options(Parameter::active()->whereGroupId(Parameter::CLASSIFICATION)->pluck('name', 'id')),
                    Forms\Components\Textarea::make('remark')
                        ->columnSpan('full')
                        ->maxLength(65535),
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
        if ($this->condition_score_id && $this->maintenance_score_id) {
            $ids = Parameter::select('id', 'value')
                ->whereIn('id', [$this->condition_score_id, $this->maintenance_score_id])
                ->get()
                ->toArray();
            $this->total_matrix = array_product(data_get($ids, '*.value'));
            $this->classification_id = Parameter::active()->whereGroupId(Parameter::CLASSIFICATION)->whereRaw('? between `from` and `to`', $this->total_matrix)
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
        unset($data['project']);
        unset($data['total_matrix']);

        $inspection = Inspection::find($this->inspect->id);
        $inspection->date = $this->date;
        $inspection->weather_id = $this->weather_id;
        $inspection->floor_no = $this->floor_no;
        $inspection->user_id = $this->user_id;
        $inspection->unit_no = $this->unit_no;
        $inspection->grid_no = $this->grid_no;
        $inspection->component_id = $this->component_id;
        $inspection->sub_component_id = $this->sub_component_id;
        $inspection->defect_id = $this->defect_id;
        $inspection->location_id = $this->location_id;
        $inspection->condition_score_id = $this->condition_score_id;
        $inspection->maintenance_score_id = $this->maintenance_score_id;
        $inspection->classification_id = $this->classification_id;
        $inspection->remark = $this->remark;
        $inspection->save();

        Notification::make()
            ->title('Updated successfully')
            ->icon('heroicon-o-check-circle')
            ->iconColor('success')
            ->send();
    }
}
