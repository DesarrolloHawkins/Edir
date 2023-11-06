<?php

namespace App\Http\Livewire\Socio;

use Livewire\Component;
use App\Models\Socio;

class IndexComponent extends Component
{
    public $socios;

    public function mount()
    {
        $this->socios = Socio::where('club_id', session()->get('clubSeleccionado'))->get();
    }
    public function render()
    {
        return view('livewire.socio.index-component');
    }

}
