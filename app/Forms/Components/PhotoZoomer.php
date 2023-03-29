<?php

namespace App\Forms\Components;

use Closure;
use Filament\Forms\Components\Field;
use Illuminate\Support\Facades\Storage;

class PhotoZoomer extends Field
{
    protected string $view = 'forms.components.photo-zoomer';
    protected string $src;

    public function src(string $src): static
    {
        $this->src = $src;
        return $this;
    }

    public function getSrc(): string
    {        
        return Storage::url($this->src);
    }
}
