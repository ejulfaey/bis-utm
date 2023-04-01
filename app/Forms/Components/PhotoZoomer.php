<?php

namespace App\Forms\Components;

use Closure;
use Filament\Forms\Components\Field;
use Illuminate\Support\Facades\Storage;
use Filament\Forms\Components\Component;

class PhotoZoomer extends Field
{
    protected string $view = 'forms.components.photo-zoomer';

    protected string | Closure | null $src;

    protected function setUp(): void
    {
        parent::setUp();

        $this->registerListeners([
            'photozoom::update' => [
                function (Component $component, $src): void {
                    $this->src = $src;
                },
            ],
        ]);
    }

    public function src(string | Closure | null $src): static
    {
        $this->src = $src;
        return $this;
    }

    public function getSrc(): string
    {
        return $this->evaluate(Storage::url($this->src));
    }
}
