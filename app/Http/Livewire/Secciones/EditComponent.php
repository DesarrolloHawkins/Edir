<?php

namespace App\Http\Livewire\Secciones;

use App\Models\Comunidad;
use App\Models\Seccion;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithFileUploads;

class EditComponent extends Component
{
    use WithFileUploads;
    use LivewireAlert;
    public $identificador;
    public $comunidad = null;
    public $comunidad_id;
    public $ruta_imagen;
    public $nombre;
    public $seccion_padre_id;
    public $orden;
    public $secciones;
    public $seccion;

    public function mount()
    {
        $this->seccion = Seccion::find($this->identificador);
        $this->orden = Seccion::all()->count() + 1;
        $this->comunidad = Comunidad::where('user_id', Auth::id())->first();
        $this->comunidad_id = $this->seccion->comunidad_id;
        $this->secciones = Seccion::all();
        $this->seccion_padre_id = $this->seccion->seccion_padre_id;
        $this->orden = $this->seccion->orden;
        $this->nombre = $this->seccion->nombre;
        $this->ruta_imagen = $this->seccion->ruta_imagen;
    }
    public function render()
    {
        return view('livewire.secciones.edit-component');
    }
}
