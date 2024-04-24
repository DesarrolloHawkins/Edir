<?php

namespace App\Http\Livewire\Comunidad;

use App\Models\Comunidad;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithFileUploads;

class IndexComponent extends Component
{
    use WithFileUploads;
    use LivewireAlert;
    public $comunidad = null;
    public $user_id;
    public $ruta_imagen;
    public $nombre;
    public $direccion;
    public $informacion_adicional;
    public function mount()
    {
        $this->user_id = Auth::user()->id;
        $comunidadId = session('comunidad_id', Comunidad::where('user_id', Auth::user()->id)->value('id'));
        $this->comunidad = Comunidad::find($comunidadId);
        if ($this->comunidad) {
            $this->ruta_imagen = $this->comunidad->ruta_imagen;
            $this->nombre = $this->comunidad->nombre;
            $this->direccion = $this->comunidad->direccion;
            $this->informacion_adicional = $this->comunidad->informacion_adicional;
        }
    }
    public function render()
    {
        return view('livewire.comunidad.index-component');
    }
    public function submit()
    {
        // Validación de datos
        $validatedData = $this->validate(
            [
                'user_id' => 'required',
                'ruta_imagen' => 'required',
                'nombre' => 'required',
                'direccion' => 'required',
                'informacion_adicional' => 'nullable',

            ],
            // Mensajes de error
            [
                'nombre.required' => 'El nombre es obligatorio.',
                'ruta_imagen.required' => 'El nombre es obligatorio.',
                'direccion.required' => 'El nombre es obligatorio.',

            ]
        );

        if ($this->comunidad != null) {
            if (Storage::disk('public')->exists('photos/' . $this->ruta_imagen) == false) {

                $name = md5($this->ruta_imagen . microtime()) . '.' . $this->ruta_imagen->extension();

                $this->ruta_imagen->storePubliclyAs('public', 'photos/' . $name);

                $validatedData['ruta_imagen'] = $name;
            }

            $comunidadSave = $this->comunidad->update($validatedData);

        } else {
            $name = md5($this->ruta_imagen . microtime()) . '.' . $this->ruta_imagen->extension();

            $this->ruta_imagen->storePubliclyAs('public', 'photos/' . $name);

            $validatedData['ruta_imagen'] = $name;
            $comunidadSave = Comunidad::create($validatedData);
            $this->comunidad = $comunidadSave;
        }
        // Guardar datos validados

        // Alertas de guardado exitoso
        if ($comunidadSave) {
            $this->alert('success', '¡Datos de la comunidad guardados correctamente!', [
                'position' => 'center',
                'timer' => 3000,
                'toast' => false,
                'showConfirmButton' => true,
                'onConfirmed' => 'confirmed',
                'confirmButtonText' => 'ok',
                'timerProgressBar' => true,
            ]);
        } else {
            $this->alert('error', '¡No se ha podido guardar la información del movimiento!', [
                'position' => 'center',
                'timer' => 3000,
                'toast' => false,
            ]);
        }
    }

    // Función para cuando se llama a la alerta
    public function getListeners()
    {
        return [
            'confirmed',
            'submit',
            'cambiarComunidad'
        ];
    }

    // Función para cuando se llama a la alerta
    public function confirmed()
    {
        // Do something
        return redirect()->route('comunidad.index');
    }
    public function cambiarComunidad($id){

        if (Comunidad::where('id', $id)->count() > 0) {
            $this->comunidad = Comunidad::where('id', $id)->first();
            $this->ruta_imagen = $this->comunidad->ruta_imagen;
            $this->nombre = $this->comunidad->nombre;
            $this->direccion = $this->comunidad->direccion;
            $this->informacion_adicional = $this->comunidad->informacion_adicional;
            session(['comunidad_id' => $id]);
        }
        $this->emit('recarga');
    }
}
