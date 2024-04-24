<?php

namespace App\Http\Livewire;

use App\Models\Comunidad;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use App\Models\Seccion;
use App\Models\User;

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
        $userid = auth()->user()->id;
        $user = User::find($userid);
        $this->alertas = $user->alertas()->wherePivot('status', 0)->get();
        $this->secciones = Seccion::all();
        $comunidadId = session('comunidad_id', Comunidad::where('user_id', Auth::user()->id)->value('id'));
        $this->comunidad = Comunidad::find($comunidadId);
        if ($this->comunidad) {
                $this->secciones_menu = Seccion::where('seccion_padre_id', 0)
                    ->where('comunidad_id', $this->comunidad->id)
                    ->orderBy('orden', 'asc')
                    ->get();
        } else {
            $this->secciones_menu = [];
        }

    }
    public function obtenerJerarquia($seccion_seleccionada)
    {
        $seccion = Seccion::find($seccion_seleccionada);
        $jerarquia = [];

        if ($seccion) {
            array_unshift($jerarquia, ' <li class="breadcrumb-item active"><a href="javascript:void(0);">' . $seccion->nombre . '</a></li>');

            while ($seccion->seccion_padre_id != 0) {
                $seccion = Seccion::find($seccion->seccion_padre_id);
                array_unshift($jerarquia, ' <li class="breadcrumb-item active"><a href="javascript:void(0);">' . $seccion->nombre . '</a></li>');
            }
        }

        echo implode('', $jerarquia);
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

        if ($this->comunidad) {
            $this->secciones_menu = Seccion::where('seccion_padre_id', 0)
                ->where('comunidad_id', $this->comunidad->id)
                ->orderBy('orden', 'asc')
                ->get();
        }

        $this->emit('orderUpdated');
    }
    public function marcarComoLeida($alertaId)
    {
        $userid = auth()->user()->id;
        $user = User::find($userid);
        $user->alertas()->updateExistingPivot($alertaId, ['status' => 1]);
    }

    public function cambiarComunidad($id)
    {
        $this->comunidad = Comunidad::find($id);
        if ($this->comunidad) {
            $this->secciones_menu = Seccion::where('seccion_padre_id', 0)
                ->where('comunidad_id', $this->comunidad->id)
                ->orderBy('orden', 'asc')
                ->get();
            session(['comunidad_id' => $id]);
        } else {
            $this->secciones_menu = [];
        }

        $this->emit('refreshComponent');
        $this->emit('recarga');
    }
}
