<?php

namespace App\Http\Livewire\Avisos;

use App\Models\Alertas;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithFileUploads;

class EditComponent extends Component
{
    use WithFileUploads;
    use LivewireAlert;
    public $identificador;
    public $anuncio;
    public $titulo;
    public $descripcion;
    public $nombre;
    public $admin_user_id;
    public $tipo;
    public $url;
    public $ruta_archivo;
    public $users;
    public $datetime;
    public $user;

    public function mount()
    {
        $this->anuncio = Alertas::where('id', $this->identificador)->first();
        $this->user = Auth::user();
        $this->users = User::where('role', 2)->get();
        $this->tipo = 1;
    }
    public function render()
    {
        return view('livewire.avisos.edit-component');
    }
    public function cargarUsuarios()
    {
        foreach ($this->anuncio->users() as $user) {
        }
    }
}
