<?php

namespace App\Http\Livewire\Usuarios;

use App\Models\User;
use App\Models\Comunidad;
use Livewire\Component;

class IndexComponent extends Component
{
    // public $search;
    public $usuarios;

    public function mount()
    {
        $this->usuarios = User::all();
    }

    public function render()
    {

        return view('livewire.usuarios.index-component');
    }

    public function getComunidad($id){
        $comunidad = Comunidad::where('user_id', $id)->first();
        if($comunidad != null){
            return $comunidad->nombre;
        }else{
            return "Comunidad sin asignar";
        }
    }

}
