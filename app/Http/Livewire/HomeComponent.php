<?php

namespace App\Http\Livewire;

use App\Models\Comunidad;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use App\Models\Seccion;

class HomeComponent extends Component
{
    public $secciones;
    public $comunidad;
    public $seccion_seleccionada;
    public $secciones_menu;
    public $alertas;
    protected $listeners = ['seleccionarSeccion', 'refreshComponent' => '$refresh', 'cambiarComunidad'];
    public function mount()
    {
        $this->alertas = auth()->user()->alertas()->wherePivot('status', 0)->get();
        $this->comunidad = Comunidad::where('user_id', Auth::user()->id)->first();
        $this->secciones = Seccion::all();
        $this->secciones_menu = Seccion::where('seccion_padre_id', 0)->where('comunidad_id', $this->comunidad->id)->orderBy('orden', 'asc')->get();
    }
    public function obtenerJerarquia($seccion_seleccionada)
    {
        $seccion = Seccion::where('id', $seccion_seleccionada)->first();

        $jerarquia = array();
        $jerarquia[0] = ' <li class="breadcrumb-item active"><a
        href="javascript:void(0);">' . $seccion->nombre . '</a>
</li>';
        while ($seccion->seccion_padre_id != 0) {
            $seccion = Seccion::where('id', $seccion->seccion_padre_id)->first();
            $jerarquia[] = ' <li class="breadcrumb-item active"><a
            href="javascript:void(0);">' . $seccion->nombre . '</a>
    </li>';
        }
        echo implode('', array_reverse($jerarquia));
    }
    public function render()
    {
        return view('livewire.home-component');
    }
    public function seleccionarSeccion($id)
    {
        $this->seccion_seleccionada = $id;
        $this->emit('refreshComponent');
    }
    public function updateOrder($list)
    {
        foreach ($list as $item) {
            Seccion::find($item['value'])->update(['orden' => $item['order']]);
        }

        $this->secciones_menu = Seccion::where('seccion_padre_id', 0)->where('comunidad_id', $this->comunidad->id)->orderBy('orden', 'asc')->get();

        $this->emit('orderUpdated');
    }
    public function marcarComoLeida($alertaId)
    {
        $user = auth()->user();
        $user->alertas()->updateExistingPivot($alertaId, ['status' => 1]);
    }

    public function cambiarComunidad($id){
        $this->comunidad = Comunidad::where('id', $id)->first();
        $this->secciones_menu = Seccion::where('seccion_padre_id', 0)->where('comunidad_id', $this->comunidad->id)->orderBy('orden', 'asc')->get();
        $this->emit('refreshComponent');
    }
}
