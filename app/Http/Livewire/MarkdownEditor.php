<?php

namespace App\Http\Livewire;

use Livewire\Component;

class MarkdownEditor extends Component
{
    public $name;

    public $input = '';

    public $preview = false;

    public function render()
    {
        return view('livewire.markdown-editor');
    }
}
