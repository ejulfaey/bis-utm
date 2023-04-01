<?php

namespace App\Forms\Components;

use Closure;
use Filament\Forms\Components\Field;

class PhotoSlider extends Field
{
    protected string $view = 'forms.components.photo-slider';
    protected array | Closure $options = [];

    public function options(array | Closure $options): static
    {
        $this->options = $options;
        return $this;
    }

    public function getOptions(): array
    {
        return $this->evaluate($this->getState());
    }

}
