<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class FormInput extends Component
{
    /**
     * Create a new component instance.
     */
    public $label;
    public $type;
    public $name;
    public $value;
    public $placeholder;
    public $required;
    public $readonly;

    public function __construct(
        $label,
        $name,
        $value = '',
        $type = 'text',
        $placeholder = '',
        $required = false,
        $readonly = false
    ) {
        $this->label = $label;
        $this->name = $name;
        $this->value = $value;
        $this->type = $type;
        $this->placeholder = $placeholder;
        $this->required = $required;
        $this->readonly = $readonly;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render()
    {
        return view('components.form-input');
    }
}
