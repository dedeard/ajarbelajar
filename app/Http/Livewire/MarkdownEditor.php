<?php

namespace App\Http\Livewire;

use Livewire\Component;

class MarkdownEditor extends Component
{
    public $name;

    public $help;

    public $value;

    public $input = '';

    public $preview = false;

    public function setInput($value)
    {
        $this->input = $value;
    }

    public function render()
    {
        return view('livewire.markdown-editor');
    }
}
