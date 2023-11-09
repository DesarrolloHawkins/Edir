<?php

namespace App\Http\Livewire\Secciones;

use App\Models\Comunidad;
use App\Models\Seccion;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class IndexComponent extends Component
{
    public $comunidad;
    public $secciones;
    protected $listeners = ['cambiarComunidad', 'refreshComponent' => '$refresh'];

    public function mount()
    {
        $this->comunidad = Comunidad::where('user_id', Auth::user()->id)->first();
        $this->secciones = Seccion::where('comunidad_id', $this->comunidad->id)->get();
    }
    public function render()
    {
        return view('livewire.secciones.index-component');
    }
    public function cambiarComunidad($id)
    {
        $this->comunidad = Comunidad::where('id', $id)->first();
        $this->secciones = Seccion::where('comunidad_id', $this->comunidad->id)->get();
        $this->emit('refreshComponent');
        }
}
