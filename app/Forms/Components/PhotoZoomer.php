<?php

namespace App\Forms\Components;

use Closure;
use Filament\Forms\Components\Field;

class PhotoZoomer extends Field
{
    protected string $view = 'forms.components.photo-zoomer';
    protected string | Closure $src;

    public function src(string | Closure $src): static
    {
        $this->src = $src;
        return $this;
    }

    public function getSrc(): string
    {
        return $this->evaluate($this->src);
    }
}
