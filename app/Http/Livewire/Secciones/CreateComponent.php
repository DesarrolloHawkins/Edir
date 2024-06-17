<?php

namespace App\Http\Livewire\Secciones;

use App\Models\Comunidad;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Seccion;

class CreateComponent extends Component
{
    use WithFileUploads;
    use LivewireAlert;
    public $comunidad = null;
    public $comunidad_id;
    public $ruta_imagen;
    public $nombre;
    public $seccion_padre_id;
    public $orden;
    public $secciones;
    public $seccion_incidencias = false;
    public function mount()
    {
        $this->comunidad_id = session('comunidad_id', Auth::user()->comunidad_id);
        $this->comunidad = Comunidad::where('id', $this->comunidad_id)->first();
        $this->secciones = Seccion::where('comunidad_id', $this->comunidad->id)->get();
        $this->orden = Seccion::where('comunidad_id', $this->comunidad->id)->count() + 1;
        $this->seccion_padre_id = 0;

    }
    public function render()
    {
        return view('livewire.secciones.create-component');
    }
    public function submit()
    {
        // Validación de datos
        $validatedData = $this->validate(
            [
                'comunidad_id' => 'required',
                'seccion_padre_id' => 'nullable',
                'nombre' => 'required',
                'orden' => 'required',
                'ruta_imagen' => 'required',
                'seccion_incidencias' => 'required',

            ],
            // Mensajes de error
            [
                'comunidad_id.required' => 'required',
                'nombre.required' => 'required',
                'orden.required' => 'required',
                'ruta_imagen.required' => 'required',
                'seccion_incidencias.required' => 'required',
            ]
        );
        $name = md5($this->ruta_imagen . microtime()) . '.' . $this->ruta_imagen->extension();

        $this->ruta_imagen->storePubliclyAs('public', 'photos/' . $name);

        $validatedData['ruta_imagen'] = $name;
        // Guardar datos validados
        $usuariosSave = Seccion::create($validatedData);

        // Alertas de guardado exitoso
        if ($usuariosSave) {
            $this->alert('success', 'Sección registrada correctamente!', [
                'position' => 'center',
                'timer' => 3000,
                'toast' => false,
                'showConfirmButton' => true,
                'onConfirmed' => 'confirmed',
                'confirmButtonText' => 'ok',
                'timerProgressBar' => true,
            ]);
        } else {
            $this->alert('error', '¡No se ha podido guardar la información del socio!', [
                'position' => 'center',
                'timer' => 3000,
                'toast' => false,
            ]);
        }
    }

    public function alertaGuardar()
    {
        $this->alert('warning', 'Asegúrese de que todos los datos son correctos antes de guardar.', [
            'position' => 'center',
            'toast' => false,
            'showConfirmButton' => true,
            'onConfirmed' => 'submit',
            'confirmButtonText' => 'Sí',
            'showDenyButton' => true,
            'denyButtonText' => 'No',
            'timerProgressBar' => true,
        ]);
    }
    public function getListeners()
    {
        return [
            'submit',
            'confirmed',
            'alertaGuardar'

        ];
    }

    public function confirmed()
    {
        // Do something
        return redirect()->route('secciones.index');
    }
}
