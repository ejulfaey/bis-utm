<?php

namespace App\Http\Livewire\Inspection;

use App\Forms\Components\PhotoZoomer;
use App\Models\Inspection;
use App\Models\Parameter;
use App\Models\Project;
use Filament\Pages\Page;
use Filament\Forms;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Livewire\TemporaryUploadedFile;

class CreateInspect extends Page implements Forms\Contracts\HasForms
{
    use Forms\Concerns\InteractsWithForms;

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
    public $continue = false;
    public $photos = [];

    protected static ?string $navigationLabel = 'Create Inspection';

    protected static string $view = 'livewire.inspection.create-inspect';

    protected function getBreadcrumbs(): array
    {
        return [
            '/inspection' => 'Inspection',
            route('inspection.create') => 'Create',
        ];
    }

    public function mount(): void
    {
        $this->user_id = auth()->id();
        $this->date = today();
        $this->weather_id = 1;
        if (request()->has('project')) {
            $this->project = Project::with('user')->findOrFail(request()->project);
            $this->project_id = $this->project->id;
        }
    }

    protected function getFormSchema(): array
    {
        return [
            Forms\Components\Section::make('Project Info')
                ->description('Description')
                ->schema([
                    Forms\Components\Select::make('project_id')
                        ->label('Project')
                        ->options(Project::pluck('name', 'id'))
                        ->reactive()
                        ->afterStateUpdated(fn ($state) => $this->onChangeProject($state))
                        ->columnSpanFull()
                        ->required(),
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
                ->columns(3),
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

    public function submit()
    {
        $data = $this->form->getState();
        $photos = $data['photos'];
        unset($data['project']);
        unset($data['photos']);
        $inspect = Inspection::create(array_merge($data, ['user_id' => auth()->id()]));

        $data_photo = Arr::map($photos, function (string $photo) use ($inspect) {
            return [
                'inspection_id' => $inspect->id,
                'photo' => $photo
            ];
        });

        DB::table('inspection_photos')->insert($data_photo);

        Notification::make()
            ->title('Saved successfully')
            ->icon('heroicon-o-check-circle')
            ->iconColor('success')
            ->send();

        return $this->continue ? redirect()->route('inspection.create', ['project' => $this->project->id]) : redirect()->route('inspection.edit', $inspect);
    }
}
