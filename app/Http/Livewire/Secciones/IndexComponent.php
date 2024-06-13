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
                $comunidadId = session('comunidad_id', Comunidad::where('id', Auth::user()->comunidad_id)->value('id'));
        $this->comunidad = Comunidad::find($comunidadId);
        // Solo carga secciones si hay una comunidad asociada al usuario
        if ($this->comunidad) {
            $this->secciones = Seccion::where('comunidad_id', $this->comunidad->id)->get();
        } else {
            $this->secciones = collect(); // Devuelve una colección vacía si no hay comunidad
        }
    }
    public function render()
    {
        return view('livewire.secciones.index-component');
    }
    public function cambiarComunidad($id)
    {
        $this->comunidad = Comunidad::find($id);
        if ($this->comunidad) {
            $this->secciones = Seccion::where('comunidad_id', $this->comunidad->id)->get();
            session(['comunidad_id' => $id]); // Almacena el ID de la comunidad en la sesión
        } else {
            $this->secciones = collect(); // Devuelve una colección vacía si no hay comunidad
        }
        $this->emit('refreshComponent');
        $this->emit('recarga');
    }
}
