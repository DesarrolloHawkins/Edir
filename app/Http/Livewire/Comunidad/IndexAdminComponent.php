<?php

namespace App\Http\Livewire\Comunidad;

use App\Models\Comunidad;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class IndexAdminComponent extends Component
{
    use LivewireAlert;
    public $comunidades;
    public $updatedCodes = [];

    public function mount()
    {
        $this->comunidades = Comunidad::all();
        foreach ($this->comunidades as $comunidad) {
            $this->updatedCodes[$comunidad->id] = $comunidad->codigo;
        }
    }

    public function updateComunidad($comunidadId)
    {
        $comunidad = Comunidad::find($comunidadId);
        $comunidad->codigo = $this->updatedCodes[$comunidadId];

        if ($comunidad->save()) {
            $this->alert('success', '¡Se ha actualizado correctamente el codigo!', [
                'timer' => 2000,
                'toast' => true,
                'showConfirmButton' => false,
                'timerProgressBar' => true,
                'width' => '300px',
                'padding' => '1rem',
                ]);
        } else {
            $this->alert('error', '¡No se ha podido guardar el codigo!', [
                'timer' => 2000,
                'toast' => true,
                'showConfirmButton' => false,
                'timerProgressBar' => true,
                'width' => '300px',
                'padding' => '1rem',
            ]);
        }
    }

    public function render()
    {
        return view('livewire.comunidad.index-admin-component');
    }
}
